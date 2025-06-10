<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use app\models\User;
use app\models\CVProfile;
use app\models\AcademicQualification;
use app\models\ProfessionalQualification;
use app\models\WorkExperience;
use app\models\TrainingWorkshop;
use app\models\Referee;

class UserController extends Controller
{
    /**
     * Set the layout for all actions
     */
    public $layout = 'velzon_layout';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['profile', 'profile-edit'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays the user's profile (view-only)
     */
    public function actionProfile()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        // Get CV Profile
        $cvProfile = CVProfile::findOne(['user_id' => $user->id]);

        // Load all profile data
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

        return $this->render('profile', [
            'user' => $user,
            'cvProfile' => $cvProfile,
            'academicQualifications' => $academicQualifications,
            'professionalQualifications' => $professionalQualifications,
            'workExperiences' => $workExperiences,
            'trainingWorkshops' => $trainingWorkshops,
            'referees' => $referees,
        ]);
    }

    /**
     * Edits the user's profile information
     */
    public function actionProfileEdit()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (!$user) {
            throw new NotFoundHttpException('User not found.');
        }

        // Get or create CV Profile
        $cvProfile = CVProfile::findOne(['user_id' => $user->id]);
        if (!$cvProfile) {
            $cvProfile = new CVProfile();
            $cvProfile->user_id = $user->id;
        }

        // Load all profile data
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

        // Handle form submission
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            
            try {
                // Debug: Log what data is being submitted
                Yii::info('POST data: ' . print_r(Yii::$app->request->post(), true), __METHOD__);
                
                // Load CV profile data (All profile information)
                if ($cvProfile->load(Yii::$app->request->post())) {
                    
                    // Debug: Log loaded attributes
                    Yii::info('CVProfile attributes after load: ' . print_r($cvProfile->attributes, true), __METHOD__);
                    
                    // Handle date format conversion
                    if ($cvProfile->date_of_birth) {
                        // Handle different date formats
                        $dateFormats = ['Y-m-d', 'm/d/Y', 'd/m/Y', 'Y/m/d'];
                        $parsedDate = null;
                        
                        foreach ($dateFormats as $format) {
                            $date = \DateTime::createFromFormat($format, $cvProfile->date_of_birth);
                            if ($date !== false) {
                                $parsedDate = $date->format('Y-m-d');
                                break;
                            }
                        }
                        
                        if ($parsedDate) {
                            $cvProfile->date_of_birth = $parsedDate;
                            Yii::info('Date converted to: ' . $cvProfile->date_of_birth, __METHOD__);
                        }
                    }
                    
                    // Handle file upload for profile picture
                    $uploadedFile = UploadedFile::getInstance($cvProfile, 'profilePictureFile');
                    
                    if ($uploadedFile) {
                        // Create uploads directory if it doesn't exist
                        $uploadDir = Yii::getAlias('@webroot/uploads/profile-pictures/');
                        if (!is_dir($uploadDir)) {
                            if (!mkdir($uploadDir, 0755, true)) {
                                throw new \Exception('Failed to create upload directory');
                            }
                        }

                        // Validate file
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        $maxSize = 2 * 1024 * 1024; // 2MB
                        
                        if (!in_array(strtolower($uploadedFile->extension), $allowedExtensions)) {
                            throw new \Exception('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
                        }
                        
                        if ($uploadedFile->size > $maxSize) {
                            throw new \Exception('File size too large. Maximum allowed size is 2MB.');
                        }

                        // Generate unique filename
                        $fileName = 'profile_' . $user->id . '_' . time() . '.' . $uploadedFile->extension;
                        $filePath = $uploadDir . $fileName;

                        // Upload the file
                        if ($uploadedFile->saveAs($filePath)) {
                            // Delete old profile picture if exists
                            if ($cvProfile->profile_picture && file_exists(Yii::getAlias('@webroot') . $cvProfile->profile_picture)) {
                                unlink(Yii::getAlias('@webroot') . $cvProfile->profile_picture);
                            }
                            
                            // Save new path (relative to web root)
                            $cvProfile->profile_picture = '/uploads/profile-pictures/' . $fileName;
                            Yii::info('Profile picture uploaded successfully: ' . $fileName, __METHOD__);
                        } else {
                            throw new \Exception('Failed to upload profile picture');
                        }
                    }

                    // Clean up URLs (add https:// if missing)
                    $urlFields = ['linkedin_url', 'github_url', 'website_url', 'twitter_url'];
                    foreach ($urlFields as $field) {
                        if (!empty($cvProfile->$field)) {
                            $url = trim($cvProfile->$field);
                            if (!empty($url) && !preg_match('#^https?://#', $url)) {
                                $cvProfile->$field = 'https://' . $url;
                            }
                        }
                    }

                    // Debug: Log final attributes before save
                    Yii::info('CVProfile attributes before save: ' . print_r($cvProfile->attributes, true), __METHOD__);

                    // Save the CV profile
                    if ($cvProfile->save()) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Profile updated successfully!');
                        
                        // Redirect to prevent form resubmission
                        return $this->redirect(['profile-edit']);
                    } else {
                        Yii::error('CVProfile validation errors: ' . print_r($cvProfile->errors, true), __METHOD__);
                        throw new \Exception('Failed to save profile data: ' . implode(', ', $cvProfile->getFirstErrors()));
                    }
                } else {
                    Yii::error('CVProfile failed to load POST data', __METHOD__);
                    throw new \Exception('No profile data was submitted for saving');
                }
                
            } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::error('Profile update failed: ' . $e->getMessage(), __METHOD__);
                Yii::$app->session->setFlash('error', 'Failed to update profile: ' . $e->getMessage());
            }
        }

        return $this->render('profile-edit', [
            'user' => $user,
            'cvProfile' => $cvProfile,
            'academicQualifications' => $academicQualifications,
            'professionalQualifications' => $professionalQualifications,
            'workExperiences' => $workExperiences,
            'trainingWorkshops' => $trainingWorkshops,
            'referees' => $referees,
        ]);
    }

    /**
     * Override the view path to use JobPortal directory structure
     */
    public function getViewPath()
    {
        return Yii::getAlias('@app/views/JobPortal/System/User');
    }
}
