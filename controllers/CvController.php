<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\CVDocument;
use app\models\User;
use app\models\CVProfile;
use app\models\AcademicQualification;
use app\models\ProfessionalQualification;
use app\models\WorkExperience;
use app\models\TrainingWorkshop;
use app\models\Referee;

class CvController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'save-cv' => ['POST'],
                    'check-saved-cv' => ['GET'],
                ],
            ],
        ];
    }

    // Action to display builder page
    public function actionBuilder()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        // Get CV Profile - exactly like in UserController
        $cvProfile = CVProfile::findOne(['user_id' => $user->id]);

        // Load all profile data - exactly like in UserController
        $academicQualifications = AcademicQualification::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['end_year' => SORT_DESC, 'start_year' => SORT_DESC])
            ->all();

        $professionalQualifications = ProfessionalQualification::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['issued_date' => SORT_DESC])
            ->all();

        $workExperiences = WorkExperience::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['start_date' => SORT_DESC])
            ->all();

        $trainingWorkshops = TrainingWorkshop::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['start_date' => SORT_DESC])
            ->all();

        $referees = Referee::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();
        
        // Load user's saved CVs for the sidebar
        $savedCVs = CVDocument::find()
            ->where(['user_id' => $user->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();
    
        return $this->render('//JobPortal/System/User/cv/builder', [
            'user' => $user,
            'cvProfile' => $cvProfile,
            'academicQualifications' => $academicQualifications,
            'professionalQualifications' => $professionalQualifications,
            'workExperiences' => $workExperiences,
            'trainingWorkshops' => $trainingWorkshops,
            'referees' => $referees,
            'savedCVs' => $savedCVs, // <-- Add this line
        ]);
    }

    /**
     * Store CV builder data temporarily in session
     */
    public function actionStoreBuilderData()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        if (Yii::$app->request->isAjax) {
            // Get the data
            $data = Yii::$app->request->post();
            
            // Create new CV document or update existing
            $cv = new CVDocument();
            $cv->user_id = Yii::$app->user->id;
            $cv->data = json_encode($data);
            $cv->name = "CV Created on " . date('Y-m-d H:i');
            
            if ($cv->save()) {
                // Return success with CV ID
                return [
                    'success' => true,
                    'message' => 'CV data saved successfully',
                    'cv_id' => $cv->id,
                ];
            }
            
            // Return error if save failed
            return [
                'success' => false,
                'message' => 'Failed to save CV data',
                'errors' => $cv->errors,
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Invalid request',
        ];
    }

    /**
     * CV Templates page
     */
    public function actionTemplates($id = null)
    {
        $userId = Yii::$app->user->id;
        
        // Get user and profile data
        $user = User::findOne($userId);
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }
        
        $cvProfile = CVProfile::findOne(['user_id' => $userId]);
        
        // Get all saved CVs for this user
        $savedCVs = CVDocument::find()
            ->where(['user_id' => $userId])
            ->orderBy(['updated_at' => SORT_DESC])
            ->all();
        
        // Determine which CV to display
        $selectedCV = null;
        if ($id) {
            $selectedCV = CVDocument::findOne(['id' => $id, 'user_id' => $userId]);
        }
        
        if (!$selectedCV && !empty($savedCVs)) {
            // Get the active CV or the most recent one
            $selectedCV = CVDocument::findOne(['user_id' => $userId, 'is_active' => 1]);
            if (!$selectedCV) {
                $selectedCV = $savedCVs[0]; // Most recent
            }
        }
        
        // If no CV found, redirect to builder
        if (!$selectedCV) {
            Yii::$app->session->setFlash('error', 'No saved CV found. Please create your CV first.');
            return $this->redirect(['/cv/builder']);
        }
        
        // Decode the CV data
        $cvData = $selectedCV->getDecodedData();
        
        // Initialize arrays
        $workExperiences = [];
        $academicQualifications = [];
        $professionalQualifications = [];
        $trainingWorkshops = [];
        $referees = [];
        
        // Get related data based on CV selections
        if (isset($cvData['selectedExperiences']) && is_array($cvData['selectedExperiences']) && !empty($cvData['selectedExperiences'])) {
            $workExperiences = WorkExperience::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $cvData['selectedExperiences']])
                ->all();
        }
        
        if (isset($cvData['selectedEducation']) && is_array($cvData['selectedEducation']) && !empty($cvData['selectedEducation'])) {
            $academicQualifications = AcademicQualification::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $cvData['selectedEducation']])
                ->all();
        }
        
        if (isset($cvData['selectedCertifications']) && is_array($cvData['selectedCertifications']) && !empty($cvData['selectedCertifications'])) {
            $professionalQualifications = ProfessionalQualification::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $cvData['selectedCertifications']])
                ->all();
        }
        
        if (isset($cvData['selectedTraining']) && is_array($cvData['selectedTraining']) && !empty($cvData['selectedTraining'])) {
            $trainingWorkshops = TrainingWorkshop::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $cvData['selectedTraining']])
                ->all();
        }
        
        if (isset($cvData['selectedReferees']) && is_array($cvData['selectedReferees']) && !empty($cvData['selectedReferees'])) {
            $referees = Referee::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $cvData['selectedReferees']])
                ->all();
        }
        
        return $this->render('//JobPortal/System/User/cv/templates', [
            'user' => $user,
            'cvProfile' => $cvProfile,
            'selectedCV' => $selectedCV,
            'savedCVs' => $savedCVs,
            'cvData' => $cvData,
            'workExperiences' => $workExperiences,
            'academicQualifications' => $academicQualifications,
            'professionalQualifications' => $professionalQualifications,
            'trainingWorkshops' => $trainingWorkshops,
            'referees' => $referees,
        ]);
    }

    public function actionUpload()
    {
        return $this->render('//JobPortal/System/User/cv/upload');
    }

    /**
     * Override the view path to use JobPortal directory structure
     */
    public function getViewPath()
    {
        return Yii::getAlias('@app/views/JobPortal/System/User');
    }

    /**
     * Save CV data to database
     */
    public function actionSaveCv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!Yii::$app->request->isAjax) {
            return ['success' => false, 'message' => 'Invalid request'];
        }
        
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        
        if (!$data) {
            return ['success' => false, 'message' => 'No data received'];
        }
        
        $userId = Yii::$app->user->id;
        
        try {
            // Check if user already has a CV document
            $cvDocument = CVDocument::findOne(['user_id' => $userId, 'is_active' => 1]);
            
            if (!$cvDocument) {
                $cvDocument = new CVDocument();
                $cvDocument->user_id = $userId;
                $cvDocument->name = 'My CV - ' . date('Y-m-d H:i:s');
                $cvDocument->is_active = 1;
            }
            
            // Store the CV data as JSON
            $cvDocument->data = json_encode($data);
            
            if ($cvDocument->save()) {
                return [
                    'success' => true, 
                    'message' => 'CV saved successfully',
                    'cvId' => $cvDocument->id
                ];
            } else {
                return [
                    'success' => false, 
                    'message' => 'Failed to save CV: ' . implode(', ', $cvDocument->getFirstErrors())
                ];
            }
            
        } catch (\Exception $e) {
            Yii::error('CV Save Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Database error occurred'];
        }
    }

    /**
     * Check if user has saved CV
     */
    public function actionCheckSavedCv()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!Yii::$app->request->isAjax) {
            return ['success' => false, 'message' => 'Invalid request'];
        }
        
        try {
            $userId = Yii::$app->user->id;
            $cvDocument = CVDocument::findOne(['user_id' => $userId, 'is_active' => 1]);
            
            return [
                'success' => true,
                'hasSavedCV' => $cvDocument !== null,
                'cvId' => $cvDocument ? $cvDocument->id : null
            ];
        } catch (\Exception $e) {
            Yii::error('Check CV Error: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Error checking CV status'];
        }
    }

    /**
     * View saved CV
     */
    public function actionViewMyCv($id = null)
    {
        $userId = Yii::$app->user->id;
        
        // If specific CV ID is provided, load that CV, otherwise load the active one
        if ($id) {
            $cvDocument = CVDocument::findOne(['id' => $id, 'user_id' => $userId]);
        } else {
            $cvDocument = CVDocument::findOne(['user_id' => $userId, 'is_active' => 1]);
        }
        
        if (!$cvDocument) {
            Yii::$app->session->setFlash('error', 'CV not found. Please create and save your CV first.');
            return $this->redirect(['/cv/builder']);
        }
        
        // Decode saved CV data - THIS IS THE MAIN DATA SOURCE
        $savedData = $cvDocument->getDecodedData();
        
        // Get user and CV profile for basic info
        $user = User::findOne($userId);
        $cvProfile = CVProfile::findOne(['user_id' => $userId]);
        
        // Load user's saved CVs for the sidebar
        $savedCVs = CVDocument::find()
            ->where(['user_id' => $userId])
            ->orderBy(['updated_at' => SORT_DESC])
            ->limit(5)
            ->all();
    
        // Only get the data that was actually selected and saved
        $workExperiences = [];
        $academicQualifications = [];
        $professionalQualifications = [];
        $trainingWorkshops = [];
        $referees = [];
        
        // Load only the items that were selected in the saved CV
        if (isset($savedData['selectedExperiences']) && !empty($savedData['selectedExperiences'])) {
            $workExperiences = WorkExperience::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $savedData['selectedExperiences']])
                ->all();
        }
        
        if (isset($savedData['selectedEducation']) && !empty($savedData['selectedEducation'])) {
            $academicQualifications = AcademicQualification::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $savedData['selectedEducation']])
                ->all();
        }
        
        if (isset($savedData['selectedCertifications']) && !empty($savedData['selectedCertifications'])) {
            $professionalQualifications = ProfessionalQualification::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $savedData['selectedCertifications']])
                ->all();
        }
        
        if (isset($savedData['selectedTraining']) && !empty($savedData['selectedTraining'])) {
            $trainingWorkshops = TrainingWorkshop::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $savedData['selectedTraining']])
                ->all();
        }
        
        if (isset($savedData['selectedReferees']) && !empty($savedData['selectedReferees'])) {
            $referees = Referee::find()
                ->where(['user_id' => $userId])
                ->andWhere(['id' => $savedData['selectedReferees']])
                ->all();
        }
        
        return $this->render('//JobPortal/System/User/cv/view-cv', [
            'cvDocument' => $cvDocument,  // The main CV document with save info
            'savedData' => $savedData,    // The JSON data that controls what to show
            'user' => $user,
            'cvProfile' => $cvProfile,
            'savedCVs' => $savedCVs,      // For sidebar
            'workExperiences' => $workExperiences,           // Only selected items
            'academicQualifications' => $academicQualifications,  // Only selected items
            'professionalQualifications' => $professionalQualifications,  // Only selected items
            'trainingWorkshops' => $trainingWorkshops,       // Only selected items
            'referees' => $referees,                         // Only selected items
        ]);
    }
}
