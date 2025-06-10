<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use app\models\User; // Ensure the User model is imported

class WebsiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['profile', 'account-settings'], // only apply to these actions
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // any authenticated user
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $this->layout = 'velzon_layout';
        return $this->render('//JobPortal/job-landing');
    }

    /**
     * Handles user login
     * 
     * @return mixed
     */
    public function actionAuthSignin()
    {
        $this->layout = false; // Use no layout for auth pages
        
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            try {
                $postData = Yii::$app->request->post();
                
                // Validate required fields
                if (empty($postData['email']) || empty($postData['password'])) {
                    return [
                        'success' => false,
                        'message' => 'Please enter both email and password.',
                        'type' => 'validation_error'
                    ];
                }
                
                // Find user by email
                $user = User::findByEmail($postData['email']);
                
                // Check if user exists and password is correct
                if (!$user || !$user->validatePassword($postData['password'])) {
                    return [
                        'success' => false,
                        'message' => 'Invalid email or password.',
                        'type' => 'invalid_credentials'
                    ];
                }
                
                // Get user's full name for personalized messages
                $userName = trim($user->firstname . ' ' . $user->lastname);
                
                // Check user status based on your requirements
                if ($user->status == 0) {
                    // Status 0 = Banned user
                    return [
                        'success' => false,
                        'message' => 'Your account has been suspended or banned. Please contact support for assistance.',
                        'type' => 'account_banned',
                        'user_name' => $userName
                    ];
                }
                
                if ($user->status == 10) {
                    // Status 10 = Active user - proceed with login
                    
                    // Update last login timestamp
                    try {
                        $db = Yii::$app->db;
                        $updateQuery = "UPDATE user SET last_login = NOW() WHERE id = :id";
                        $db->createCommand($updateQuery, [':id' => $user->id])->execute();
                    } catch (\Exception $e) {
                        // Log error but don't fail login for this
                        Yii::warning("Failed to update last login for user {$user->id}: " . $e->getMessage());
                    }
                    
                    // Login the user
                    if (Yii::$app->user->login($user, isset($postData['remember']) ? 3600 * 24 * 30 : 0)) {
                        // Determine redirect URL based on user role
                        $redirectUrl = '/user/dashboard'; // Default
                        
                        if ($user->isAdmin()) {
                            $redirectUrl = '/admin/dashboard';
                        } elseif (isset($user->role)) {
                            switch ($user->role) {
                                case 2: // Admin
                                    $redirectUrl = '/admin/dashboard';
                                    break;
                                case 3: // Employer
                                    $redirectUrl = '/employer/dashboard';
                                    break;
                                case 1: // Regular User
                                default:
                                    $redirectUrl = '/user/dashboard';
                                    break;
                            }
                        }
                        
                        return [
                            'success' => true,
                            'message' => 'Login successful! Redirecting...',
                            'redirect' => $redirectUrl,
                            'user_name' => $userName
                        ];
                    } else {
                        return [
                            'success' => false,
                            'message' => 'Login failed. Please try again.',
                            'type' => 'login_failed'
                        ];
                    }
                } else {
                    // Any other status (not 0 and not 10) = Inactive/Pending
                    return [
                        'success' => false,
                        'message' => 'Your account is not active. Please contact support to activate your account.',
                        'type' => 'account_inactive',
                        'user_name' => $userName
                    ];
                }
                
            } catch (\Exception $e) {
                \Yii::error('Login error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'An error occurred during login. Please try again.',
                    'type' => 'system_error'
                ];
            }
        }
        
        // Display the signin form
        return $this->render('//JobPortal/auth-signin');
    }

    /**
     * Handles user registration
     * 
     * @return mixed
     */
    public function actionAuthSignup()
    {
        $this->layout = false; // Use no layout for auth pages
        
        if (Yii::$app->request->isAjax) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            try {
                $postData = Yii::$app->request->post();
                
                // Validate required fields exist
                $requiredFields = ['firstname', 'lastname', 'email', 'password', 'confirm-password'];
                foreach ($requiredFields as $field) {
                    if (!isset($postData[$field]) || empty(trim($postData[$field]))) {
                        return [
                            'success' => false,
                            'message' => 'All fields are required'
                        ];
                    }
                }
                
                // Check if the posted password and confirm-password match
                if ($postData['password'] !== $postData['confirm-password']) {
                    return [
                        'success' => false, 
                        'message' => 'Passwords do not match'
                    ];
                }
                
                // Check if email already exists
                $existingUser = User::find()->where(['email' => trim($postData['email'])])->one();
                if ($existingUser) {
                    return [
                        'success' => false,
                        'message' => 'An account with this email already exists'
                    ];
                }
                
                // Attempt to create the user
                $user = User::signup([
                    'firstname' => trim($postData['firstname']),
                    'lastname' => trim($postData['lastname']),
                    'email' => trim($postData['email']),
                    'password' => $postData['password']
                ]);
                
                if ($user) {
                    return [
                        'success' => true,
                        'message' => 'Your account has been created successfully'
                    ];
                } else {
                    // Create a temporary user to get validation errors
                    $tempUser = new User();
                    $tempUser->firstname = trim($postData['firstname']);
                    $tempUser->lastname = trim($postData['lastname']);
                    $tempUser->email = trim($postData['email']);
                    $tempUser->setPassword($postData['password']);
                    $tempUser->generateAuthKey();
                    $tempUser->validate();
                    
                    $errors = [];
                    foreach ($tempUser->getErrors() as $field => $fieldErrors) {
                        $errors[] = $field . ': ' . implode(', ', $fieldErrors);
                    }
                    
                    $errorMessage = !empty($errors) ? implode('; ', $errors) : 'Unknown validation error occurred';
                    
                    return [
                        'success' => false,
                        'message' => 'Validation failed: ' . $errorMessage
                    ];
                }
            } catch (\Exception $e) {
                \Yii::error('Signup error: ' . $e->getMessage());
                return [
                    'success' => false,
                    'message' => 'An error occurred: ' . $e->getMessage()
                ];
            }
        }
        
        // Display the signup form
        return $this->render('//JobPortal/auth-signup');
    }

    /**
     * Admin dashboard
     */
    public function actionAdminDashboard()
    {
        // Check if user is logged in and is admin
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->isAdmin()) {
            return $this->redirect(['/auth-signin']);
        }
        
        return $this->render('//JobPortal/System/Admin/dashboard');
    }

    /**
     * User dashboard
     */
    public function actionUserDashboard()
    {
        // Check if user is logged in
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/auth-signin']);
        }
        
        return $this->render('//JobPortal/System/User/dashboard');
    }

    /**
     * Logout action
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        // Set flash message for successful logout
        Yii::$app->session->setFlash('logout_success', 'You have been logged out successfully!');
        
        return $this->redirect(['/auth-signin']);
    }

    public function actionRoot($action = '')
    {
        $this->layout = 'velzon_layout';
        try
        {
            // Handle specific auth pages
            if ($action === 'auth-signin') {
                return $this->actionAuthSignin();
            }
            
            if ($action === 'auth-signup') {
                return $this->actionAuthSignup();
            }
            
            // Check if action starts with JobPortal/ prefix, if not add it
            if (!empty($action) && strpos($action, 'JobPortal/') !== 0) {
                $action = 'JobPortal/' . $action;
            }
            
            return $this->render($action);
        }
        catch (\Exception $e)
        {
            // Log the actual error to help with debugging
            Yii::error('View not found: ' . $action . ' - ' . $e->getMessage());
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
