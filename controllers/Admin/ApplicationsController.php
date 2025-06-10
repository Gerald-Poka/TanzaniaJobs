<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\JobApplication;
use app\models\CvDocument; // Add this line

class ApplicationsController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAll()
    {
        $query = JobApplication::find()
            ->joinWith(['job', 'applicant']) // Changed from 'user' to 'applicant'
            ->orderBy(['applied_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/all', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
        ]);
    }

    public function actionPending()
    {
        $query = JobApplication::find()
            ->where(['job_applications.status' => JobApplication::STATUS_PENDING]) // Specify the table name
            ->joinWith(['job', 'applicant'])
            ->orderBy(['applied_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/pending', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
        ]);
    }

    public function actionApproved()
    {
        $query = JobApplication::find()
            ->where(['job_applications.status' => JobApplication::STATUS_ACCEPTED]) // Specify the table name
            ->joinWith(['job', 'applicant'])
            ->orderBy(['applied_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/approved', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
        ]);
    }

    public function actionRejected()
    {
        $query = JobApplication::find()
            ->where(['job_applications.status' => JobApplication::STATUS_REJECTED]) // Specify the table name
            ->joinWith(['job', 'applicant'])
            ->orderBy(['applied_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/rejected', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
        ]);
    }

    public function actionShortlisted()
    {
        $query = JobApplication::find()
            ->where(['job_applications.status' => JobApplication::STATUS_SHORTLISTED]) // Specify the table name
            ->joinWith(['job', 'applicant'])
            ->orderBy(['applied_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/shortlisted', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
        ]);
    }

    public function actionUpdateStatus($id)
    {
        $application = JobApplication::findOne($id);
        
        if ($application && Yii::$app->request->isPost) {
            $application->status = Yii::$app->request->post('status');
            
            if ($application->save()) {
                Yii::$app->session->setFlash('success', 'Application status updated successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to update application status.');
            }
        }

        return $this->redirect(['all']);
    }

    /**
     * View a single application details
     * 
     * @param int $id Application ID
     * @return string
     */
    public function actionView($id)
    {
        $model = JobApplication::findOne($id);
        
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('The requested application does not exist.');
        }
        
        // Get the applicant (user) details
        $applicant = $model->applicant;
        
        // Debug available job fields - comment this out after identifying the field
        if ($model->job) {
            Yii::debug('Job model fields: ' . print_r(array_keys($model->job->attributes), true));
        }
        
        // Get application data in array format for easier access in view
        $application = [
            'id' => $model->id,
            'job_title' => $model->job ? $model->job->title : 'N/A',
            'job_location' => $model->job ? $model->job->location : 'N/A',
            
            // Try different field names that might contain job type information
            'job_type' => $model->job ? ($model->job->job_type ?? $model->job->type ?? $model->job->employment_type ?? 'N/A') : 'N/A',
            
            'company_name' => $model->job && $model->job->company ? $model->job->company->name : 'N/A',
            'company_logo' => $model->job && $model->job->company ? $model->job->company->logo : null,
            'company_verified' => $model->job && $model->job->company && isset($model->job->company->verified) ? $model->job->company->verified : false,
            'status' => $model->status,
            'cover_letter' => $model->cover_letter,
            'expected_salary' => $model->expected_salary,
            'availability_date' => $model->availability_date,
            'resume_file' => $model->resume_file,
            'cv_document_id' => $model->cv_document_id,
            'notes' => $model->notes,
            'applied_at' => $model->applied_at,
            'applicant_id' => $model->applicant_id,
            'salary_currency' => 'USD', // Add this line to prevent undefined array key
        ];
        
        // Get statuses list for dropdown
        $statuses = JobApplication::getStatusList();

        return $this->render('@app/views/JobPortal/System/Admin/applications/view', [
            'model' => $model,
            'application' => $application,
            'applicant' => $applicant,
            'statuses' => $statuses,
        ]);
    }
    
    /**
     * View application CV in browser
     * 
     * @param int $id CV document ID
     * @return \yii\web\Response
     */
    public function actionViewCv($id)
    {
        $document = CvDocument::findOne($id);
        
        if (!$document) {
            throw new \yii\web\NotFoundHttpException('The requested CV document does not exist.');
        }
        
        // For system-generated CVs, display the content directly
        if ($document->is_system_generated) {
            return $this->renderPartial('_cv_preview', [
                'document' => $document,
            ]);
        } else {
            // For uploaded PDFs, stream the file for viewing in browser
            $filePath = Yii::getAlias('@webroot') . $document->file_path;
            
            if (!file_exists($filePath)) {
                throw new \yii\web\NotFoundHttpException('The CV file does not exist.');
            }
            
            return Yii::$app->response->sendFile(
                $filePath, 
                $document->filename,
                ['inline' => true] // This makes it display in the browser rather than download
            );
        }
    }

    /**
     * Download CV document
     * 
     * @param int $id CV document ID
     * @return \yii\web\Response
     */
    public function actionDownloadCv($id)
    {
        $document = CvDocument::findOne($id);
        
        if (!$document) {
            throw new \yii\web\NotFoundHttpException('The requested CV document does not exist.');
        }
        
        // For system-generated CVs, generate a PDF on the fly
        if ($document->is_system_generated) {
            // Generate PDF from the CV content
            $pdf = new \kartik\mpdf\Pdf([
                'mode' => \kartik\mpdf\Pdf::MODE_CORE,
                'format' => \kartik\mpdf\Pdf::FORMAT_A4,
                'orientation' => \kartik\mpdf\Pdf::ORIENT_PORTRAIT,
                'destination' => \kartik\mpdf\Pdf::DEST_BROWSER,
                'content' => $this->renderPartial('@app/views/JobPortal/System/Admin/applications/_cv_pdf', [
                    'document' => $document,
                ]),
                'cssFile' => '@webroot/css/cv-pdf.css',
                'options' => [
                    'title' => 'CV - ' . $document->user->firstname . ' ' . $document->user->lastname,
                ],
                'methods' => [
                    'SetFooter' => ['{PAGENO}'],
                ]
            ]);
            
            return $pdf->render();
        } else {
            // For uploaded PDFs, just download the file
            $filePath = Yii::getAlias('@webroot') . $document->file_path;
            
            if (!file_exists($filePath)) {
                throw new \yii\web\NotFoundHttpException('The CV file does not exist.');
            }
            
            return Yii::$app->response->sendFile($filePath, $document->filename);
        }
    }
}