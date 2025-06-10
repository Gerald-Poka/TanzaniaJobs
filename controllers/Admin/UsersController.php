<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UsersController extends Controller
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
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'ban' => ['POST'],
                    'activate' => ['POST'],
                ],
            ],
        ];
    }

    public function actionAll() 
    {
        try {
            // Get database connection
            $db = Yii::$app->db;
            
            // Query to get users with role = 1 (normal users)
            // Updated to match your actual table structure
            $query = "SELECT 
                        id, 
                        CONCAT(firstname, ' ', lastname) as name,
                        firstname,
                        lastname,
                        email, 
                        status, 
                        FROM_UNIXTIME(created_at) as created_at,
                        FROM_UNIXTIME(updated_at) as last_login
                      FROM user 
                      WHERE role = 1 
                      ORDER BY created_at DESC";
            
            // Execute query
            $users = $db->createCommand($query)->queryAll();
            
            // Process the data to match the view expectations
            foreach ($users as &$user) {
                $user['username'] = ''; // Since username doesn't exist in your table
                
                // Convert status numbers to readable format
                if ($user['status'] == 10) {
                    $user['status'] = 'active';
                } else {
                    $user['status'] = 'inactive';
                }
            }
            
            // Render the view with correct path
            return $this->render('/JobPortal/System/Admin/users/n_users', [
                'users' => $users,
                'title' => 'All Users',
                'pageTitle' => 'User Management'
            ]);
            
        } catch (\Exception $e) {
            // Handle error
            Yii::error("Error fetching users: " . $e->getMessage());
            
            // Show error page or redirect
            Yii::$app->session->setFlash('error', 'Failed to load users: ' . $e->getMessage());
            return $this->render('/JobPortal/System/Admin/users/n_users', [
                'users' => [],
                'error' => 'Failed to load users'
            ]);
        }
    }

    public function actionView($id) 
    {
        try {
            $db = Yii::$app->db;
            
            // Debug: Log the user ID being requested
            Yii::info("Viewing user with ID: " . $id);
            
            // Get user data
            $query = "SELECT 
                        id, 
                        CONCAT(firstname, ' ', lastname) as name,
                        firstname,
                        lastname,
                        email, 
                        status, 
                        role,
                        FROM_UNIXTIME(created_at) as created_at,
                        FROM_UNIXTIME(updated_at) as updated_at
                      FROM user 
                      WHERE id = :id AND role = 1";
            
            $user = $db->createCommand($query, [':id' => $id])->queryOne();
            
            if (!$user) {
                throw new NotFoundHttpException('User not found');
            }
            
            // Process status for display
            if ($user['status'] == 10) {
                $user['status_text'] = 'Active';
                $user['status_class'] = 'success';
            } else {
                $user['status_text'] = 'Inactive';
                $user['status_class'] = 'warning';
            }
            
            // Debug: Log user info
            Yii::info("User found: " . json_encode($user));
            
            // Get CV Profile
            $cvProfile = null;
            try {
                $cvProfileQuery = "SELECT * FROM cv_profiles WHERE user_id = :user_id";
                $cvProfile = $db->createCommand($cvProfileQuery, [':user_id' => $id])->queryOne();
                Yii::info("CV Profile found: " . ($cvProfile ? json_encode($cvProfile) : 'No data'));
            } catch (\Exception $e) {
                Yii::warning("CV Profile table error: " . $e->getMessage());
            }
            
            // Get Academic Qualifications
            $academicQualifications = [];
            try {
                $academicQuery = "SELECT * FROM academic_qualifications WHERE user_id = :user_id ORDER BY end_year DESC, start_year DESC";
                $academicQualifications = $db->createCommand($academicQuery, [':user_id' => $id])->queryAll();
                Yii::info("Academic Qualifications: " . json_encode($academicQualifications));
            } catch (\Exception $e) {
                Yii::warning("Academic Qualifications table error: " . $e->getMessage());
            }
            
            // Get Professional Qualifications
            $professionalQualifications = [];
            try {
                $professionalQuery = "SELECT * FROM professional_qualifications WHERE user_id = :user_id ORDER BY issued_date DESC, created_at DESC";
                $professionalQualifications = $db->createCommand($professionalQuery, [':user_id' => $id])->queryAll();
                
                // Debug: Log the actual structure
                if (!empty($professionalQualifications)) {
                    Yii::info("Professional Qualifications structure: " . print_r($professionalQualifications[0], true));
                    Yii::info("Professional Qualifications columns: " . implode(', ', array_keys($professionalQualifications[0])));
                }
                
                Yii::info("Professional Qualifications count: " . count($professionalQualifications));
            } catch (\Exception $e) {
                Yii::warning("Professional Qualifications table error: " . $e->getMessage());
            }
            
            // Get Work Experiences
            $workExperiences = [];
            try {
                $workQuery = "SELECT * FROM work_experiences WHERE user_id = :user_id ORDER BY start_date DESC";
                $workExperiences = $db->createCommand($workQuery, [':user_id' => $id])->queryAll();
                Yii::info("Work Experiences: " . json_encode($workExperiences));
            } catch (\Exception $e) {
                Yii::warning("Work Experiences table error: " . $e->getMessage());
            }
            
            // Get Training/Workshops
            $trainingWorkshops = [];
            try {
                $trainingQuery = "SELECT * FROM training_workshops WHERE user_id = :user_id ORDER BY start_date DESC";
                $trainingWorkshops = $db->createCommand($trainingQuery, [':user_id' => $id])->queryAll();
                Yii::info("Training Workshops: " . json_encode($trainingWorkshops));
            } catch (\Exception $e) {
                Yii::warning("Training Workshops table error: " . $e->getMessage());
            }
            
            // Get Referees
            $referees = [];
            try {
                $refereeQuery = "SELECT * FROM referees WHERE user_id = :user_id ORDER BY created_at DESC";
                $referees = $db->createCommand($refereeQuery, [':user_id' => $id])->queryAll();
                Yii::info("Referees: " . json_encode($referees));
            } catch (\Exception $e) {
                Yii::warning("Referees table error: " . $e->getMessage());
            }
            
            // Get saved CVs
            $savedCVs = [];
            try {
                $cvQuery = "SELECT * FROM cv_documents WHERE user_id = :user_id ORDER BY created_at DESC";
                $savedCVs = $db->createCommand($cvQuery, [':user_id' => $id])->queryAll();
                Yii::info("Saved CVs: " . json_encode($savedCVs));
            } catch (\Exception $e) {
                Yii::warning("CV Documents table error: " . $e->getMessage());
            }
            
            return $this->render('/JobPortal/System/Admin/users/view_user', [
                'user' => $user,
                'cvProfile' => $cvProfile,
                'academicQualifications' => $academicQualifications,
                'professionalQualifications' => $professionalQualifications,
                'workExperiences' => $workExperiences,
                'trainingWorkshops' => $trainingWorkshops,
                'referees' => $referees,
                'savedCVs' => $savedCVs,
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error viewing user: " . $e->getMessage());
            throw new NotFoundHttpException('User not found: ' . $e->getMessage());
        }
    }

    public function actionEdit($id) 
    {
        try {
            $db = Yii::$app->db;
            
            if (Yii::$app->request->isPost) {
                // Handle form submission
                $post = Yii::$app->request->post();
                $firstname = $post['firstname'] ?? '';
                $lastname = $post['lastname'] ?? '';
                $email = $post['email'] ?? '';
                $status = $post['status'] ?? 10; // Default to active (10)
                
                $query = "UPDATE user SET firstname = :firstname, lastname = :lastname, email = :email, status = :status, updated_at = :updated_at WHERE id = :id AND role = 1";
                $result = $db->createCommand($query, [
                    ':firstname' => $firstname,
                    ':lastname' => $lastname,
                    ':email' => $email,
                    ':status' => $status,
                    ':updated_at' => time(),
                    ':id' => $id
                ])->execute();
                
                if ($result) {
                    Yii::$app->session->setFlash('success', 'User updated successfully');
                    return $this->redirect(['all']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to update user');
                }
            }
            
            // Get user data for form
            $query = "SELECT * FROM user WHERE id = :id AND role = 1";
            $user = $db->createCommand($query, [':id' => $id])->queryOne();
            
            if (!$user) {
                throw new NotFoundHttpException('User not found');
            }
            
            return $this->render('/JobPortal/System/Admin/users/edit_user', ['user' => $user]);
            
        } catch (\Exception $e) {
            Yii::error("Error editing user: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Error processing request');
            return $this->redirect(['all']);
        }
    }

    public function actionBan($id) 
    {
        try {
            $db = Yii::$app->db;
            
            // First check if user exists
            $userQuery = "SELECT id, CONCAT(firstname, ' ', lastname) as name FROM user WHERE id = :id AND role = 1";
            $user = $db->createCommand($userQuery, [':id' => $id])->queryOne();
            
            if (!$user) {
                Yii::$app->session->setFlash('error', 'User not found.');
                return $this->redirect(['view', 'id' => $id]);
            }
            
            // Update user status to inactive (assuming 0 or 9 is inactive)
            $updateQuery = "UPDATE user SET status = 0, updated_at = UNIX_TIMESTAMP() WHERE id = :id";
            $result = $db->createCommand($updateQuery, [':id' => $id])->execute();
            
            if ($result) {
                Yii::$app->session->setFlash('success', 'User "' . $user['name'] . '" has been banned successfully.');
                Yii::info("User {$user['name']} (ID: {$id}) has been banned by admin.");
            } else {
                Yii::$app->session->setFlash('error', 'Failed to ban user. Please try again.');
            }
            
        } catch (\Exception $e) {
            Yii::error("Error banning user: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'An error occurred while banning the user.');
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionActivate($id) 
    {
        try {
            $db = Yii::$app->db;
            
            // First check if user exists
            $userQuery = "SELECT id, CONCAT(firstname, ' ', lastname) as name FROM user WHERE id = :id AND role = 1";
            $user = $db->createCommand($userQuery, [':id' => $id])->queryOne();
            
            if (!$user) {
                Yii::$app->session->setFlash('error', 'User not found.');
                return $this->redirect(['view', 'id' => $id]);
            }
            
            // Update user status to active (10)
            $updateQuery = "UPDATE user SET status = 10, updated_at = UNIX_TIMESTAMP() WHERE id = :id";
            $result = $db->createCommand($updateQuery, [':id' => $id])->execute();
            
            if ($result) {
                Yii::$app->session->setFlash('success', 'User "' . $user['name'] . '" has been activated successfully.');
                Yii::info("User {$user['name']} (ID: {$id}) has been activated by admin.");
            } else {
                Yii::$app->session->setFlash('error', 'Failed to activate user. Please try again.');
            }
            
        } catch (\Exception $e) {
            Yii::error("Error activating user: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'An error occurred while activating the user.');
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDelete($id) 
    {
        try {
            $db = Yii::$app->db;
            
            // First check if user exists
            $userQuery = "SELECT id, CONCAT(firstname, ' ', lastname) as name FROM user WHERE id = :id AND role = 1";
            $user = $db->createCommand($userQuery, [':id' => $id])->queryOne();
            
            if (!$user) {
                Yii::$app->session->setFlash('error', 'User not found.');
                return $this->redirect(['all']);
            }
            
            // Start transaction
            $transaction = $db->beginTransaction();
            
            try {
                // Delete related data first
                $db->createCommand("DELETE FROM cv_profiles WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM academic_qualifications WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM professional_qualifications WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM work_experiences WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM training_workshops WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM referees WHERE user_id = :user_id", [':user_id' => $id])->execute();
                $db->createCommand("DELETE FROM cv_documents WHERE user_id = :user_id", [':user_id' => $id])->execute();
                
                // Finally delete the user
                $result = $db->createCommand("DELETE FROM user WHERE id = :id", [':id' => $id])->execute();
                
                if ($result) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'User "' . $user['name'] . '" and all related data have been deleted successfully.');
                    Yii::info("User {$user['name']} (ID: {$id}) has been deleted by admin.");
                    return $this->redirect(['all']);
                } else {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Failed to delete user. Please try again.');
                }
                
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Yii::error("Error deleting user: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'An error occurred while deleting the user.');
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }
}