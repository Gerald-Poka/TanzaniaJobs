<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use app\models\Job;
use app\models\JobApplication;
use app\models\User;
use app\models\Company;

class ApplicationController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['form', 'submit'],
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'submit' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Show application form for a job
     * 
     * @param int $job_id
     * @return mixed
     */
    public function actionForm($job_id)
    {
        // Check if job exists
        $job = Job::findOne($job_id);
        if (!$job) {
            throw new NotFoundHttpException('The requested job does not exist.');
        }

        // Check if job is still valid for applications
        if ($job->status != 'published' || ($job->expires_at && $job->expires_at < date('Y-m-d H:i:s'))) {
            Yii::$app->session->setFlash('error', 'This job is no longer accepting applications.');
            return $this->redirect(['/jobs/view', 'id' => $job_id]);
        }

        // Check if user already applied
        $userId = Yii::$app->user->id;
        $existingApplication = JobApplication::findOne([
            'job_id' => $job_id,
            'applicant_id' => $userId
        ]);

        if ($existingApplication) {
            Yii::$app->session->setFlash('info', 'You have already applied for this job.');
            return $this->redirect(['/jobs/view', 'id' => $job_id]);
        }

        // Load company information
        $company = $job->company;

        // Get user's saved CVs - updated to use correct column names
        $savedCvs = Yii::$app->db->createCommand("
            SELECT id, user_id, name, created_at, updated_at, is_active 
            FROM cv_documents 
            WHERE user_id = :userId AND is_active = 1
            ORDER BY created_at DESC
        ")->bindValue(':userId', $userId)->queryAll();

        // Create new job application model
        $model = new JobApplication();
        $model->job_id = $job_id;
        $model->applicant_id = $userId;

        return $this->render('@app/views/JobPortal/System/User/application/form', [
            'model' => $model,
            'job' => $job,
            'company' => $company,
            'savedCvs' => $savedCvs,
            'title' => 'Apply for Job',
            'pageTitle' => 'Job Application Form',
        ]);
    }

    /**
     * Process job application submission
     * 
     * @param int $job_id
     * @return mixed
     */
    public function actionSubmit($job_id)
    {
        // Check if job exists
        $job = Job::findOne($job_id);
        if (!$job) {
            throw new NotFoundHttpException('The requested job does not exist.');
        }

        // Create new job application model
        $model = new JobApplication();
        $model->job_id = $job_id;
        $model->applicant_id = Yii::$app->user->id;
        $model->status = 'pending';
        $model->applied_at = date('Y-m-d H:i:s');

        // Load and validate model data
        if ($model->load(Yii::$app->request->post())) {
            
            // Handle CV selection or upload
            $selectedCvId = Yii::$app->request->post('JobApplication')['selected_cv_id'] ?? null;
            
            if ($selectedCvId) {
                // User selected an existing CV
                $cv = Yii::$app->db->createCommand("
                    SELECT * FROM cv_documents 
                    WHERE id = :cvId AND user_id = :userId AND is_active = 1
                ")->bindValues([
                    ':cvId' => $selectedCvId,
                    ':userId' => Yii::$app->user->id
                ])->queryOne();
                
                if ($cv) {
                    // Check if cv_document_id column exists in the database
                    $schema = Yii::$app->db->schema;
                    $tableSchema = $schema->getTableSchema('job_applications');
                    
                    if ($tableSchema->getColumn('cv_document_id')) {
                        // Column exists, set the property
                        $model->cv_document_id = $cv['id'];
                    }
                    
                    // Always set the resume_file property as fallback
                    $model->resume_file = "CV_" . $cv['id']; 
                } else {
                    Yii::$app->session->setFlash('error', 'Selected CV not found or you do not have permission to use it.');
                    return $this->redirect(['form', 'job_id' => $job_id]);
                }
            } else {
                // Handle new CV upload
                $resumeFile = UploadedFile::getInstance($model, 'resume_file');
                if ($resumeFile) {
                    $fileName = 'resume_' . Yii::$app->user->id . '_' . time() . '.' . $resumeFile->extension;
                    $uploadPath = Yii::getAlias('@webroot/uploads/resumes');
                    
                    // Create directory if it doesn't exist
                    if (!file_exists($uploadPath)) {
                        mkdir($uploadPath, 0777, true);
                    }
                    
                    if ($resumeFile->saveAs($uploadPath . '/' . $fileName)) {
                        $model->resume_file = $fileName;
                        
                        // If user wants to save the CV for future use
                        $saveCv = Yii::$app->request->post('save_cv');
                        if ($saveCv) {
                            $cvTitle = Yii::$app->request->post('cv_title');
                            if (empty($cvTitle)) {
                                $cvTitle = 'Resume uploaded on ' . date('Y-m-d');
                            }
                            
                            // Read file content for JSON storage
                            $fileContent = file_get_contents($uploadPath . '/' . $fileName);
                            $jsonData = json_encode([
                                'fileContent' => base64_encode($fileContent),
                                'fileName' => $fileName,
                                'fileType' => $resumeFile->type,
                                'fileExtension' => $resumeFile->extension
                            ]);
                            
                            // Save CV to cv_documents table with correct column names
                            Yii::$app->db->createCommand()->insert('cv_documents', [
                                'user_id' => Yii::$app->user->id,
                                'name' => $cvTitle,
                                'data' => $jsonData,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                                'is_active' => 1
                            ])->execute();
                            
                            // Get the ID of the newly inserted CV
                            $newCvId = Yii::$app->db->getLastInsertID();
                            if ($newCvId) {
                                $model->cv_document_id = $newCvId;
                            }
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Failed to upload resume file.');
                        return $this->redirect(['form', 'job_id' => $job_id]);
                    }
                } else if (!$selectedCvId) {
                    Yii::$app->session->setFlash('error', 'Please select a CV or upload a new one.');
                    return $this->redirect(['form', 'job_id' => $job_id]);
                }
            }
            
            // Validate and save the application
            if ($model->validate() && $model->save()) {
                // Increment application count for the job
                $job->applications_count = $job->applications_count + 1;
                $job->save(false, ['applications_count']);
                
                Yii::$app->session->setFlash('success', 'Your application has been submitted successfully.');
                return $this->redirect(['/jobs/view', 'id' => $job_id]);
            }
        }

        // If we get here, something went wrong
        Yii::$app->session->setFlash('error', 'There was an error submitting your application.');
        
        // Load company information and CVs again with correct column structure
        $company = $job->company;
        $savedCvs = Yii::$app->db->createCommand("
            SELECT id, user_id, name, created_at, updated_at, is_active 
            FROM cv_documents 
            WHERE user_id = :userId AND is_active = 1
            ORDER BY created_at DESC
        ")->bindValue(':userId', Yii::$app->user->id)->queryAll();
        
        return $this->render('@app/views/JobPortal/System/User/application/form', [
            'model' => $model,
            'job' => $job,
            'company' => $company,
            'savedCvs' => $savedCvs,
            'title' => 'Apply for Job',
            'pageTitle' => 'Job Application Form',
        ]);
    }
}