<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\data\Pagination;
use yii\helpers\Url;
// Models
use app\models\Job;
use app\models\JobCategory;
use app\models\JobSkill;
use app\models\Skill;
use app\models\SavedJob;
use app\models\Company;
use app\models\JobApplication;
use app\models\User;

class JobsController extends Controller
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
                    'save' => ['POST'],
                    'unsave' => ['POST'],
                    'apply' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Browse all published jobs (created by admin)
     */
    public function actionBrowse()
    {
        try {
            // Default filters
            $filters = [
                'search' => Yii::$app->request->get('search', ''),
                'category' => Yii::$app->request->get('category', ''),
                'location' => Yii::$app->request->get('location', ''),
                'job_type' => Yii::$app->request->get('job_type', ''),
                'experience_level' => Yii::$app->request->get('experience_level', ''),
                'salary_min' => Yii::$app->request->get('salary_min', ''),
                'salary_max' => Yii::$app->request->get('salary_max', ''),
                'sort' => Yii::$app->request->get('sort', 'newest'),
                'page' => (int)Yii::$app->request->get('page', 0),
            ];
            
            // Base query for jobs - use string value 'published' instead of constant
            $query = Job::find()
                ->where(['status' => 'published'])
                ->andWhere(['OR', ['expires_at' => null], ['>', 'expires_at', date('Y-m-d H:i:s')]]);
            
            // Count ALL jobs first (for debugging)
            $allJobsCount = Job::find()->count();
                
            // Count PUBLISHED jobs (for debugging)
            $publishedJobsCount = Job::find()->where(['status' => 'published'])->count();
                
            // Apply filters
            if (!empty($filters['search'])) {
                $query->andWhere(['or',
                    ['like', 'title', $filters['search']],
                    ['like', 'description', $filters['search']],
                    ['like', 'short_description', $filters['search']],
                    ['like', 'requirements', $filters['search']]
                ]);
            }
            
            if (!empty($filters['category'])) {
                $query->andWhere(['category_id' => $filters['category']]);
            }
            
            if (!empty($filters['location'])) {
                $query->andWhere(['like', 'location', $filters['location']]);
            }
            
            if (!empty($filters['job_type'])) {
                $query->andWhere(['job_type' => $filters['job_type']]);
            }
            
            if (!empty($filters['experience_level'])) {
                $query->andWhere(['experience_level' => $filters['experience_level']]);
            }
            
            // Apply sorting
            switch ($filters['sort']) {
                case 'salary_high':
                    $query->orderBy(['salary_max' => SORT_DESC, 'created_at' => SORT_DESC]);
                    break;
                case 'salary_low':
                    $query->orderBy(['salary_min' => SORT_ASC, 'created_at' => SORT_DESC]);
                    break;
                case 'newest':
                default:
                    $query->orderBy(['created_at' => SORT_DESC]);
                    break;
            }
            
            // Get total count with filters
            $totalCount = $query->count();
            
            // Create pagination
            $pagination = new Pagination([
                'totalCount' => $totalCount,
                'pageSize' => 9,
                'page' => $filters['page'],
            ]);
            
            // Apply pagination and fetch jobs
            $jobs = $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
            
            // Convert jobs to array and add missing fields
            $jobsArray = [];
            foreach ($jobs as $job) {
                $jobData = $job->attributes;
                
                // Get company details if available
                if ($job->company_id) {
                    $company = Company::findOne($job->company_id);
                    if ($company) {
                        $jobData['company_name'] = $company->name;
                        $jobData['company_logo'] = $company->logo;
                        // Add company_verified with a default value since it might not exist
                        $jobData['company_verified'] = $company->verified ?? 0;
                    } else {
                        $jobData['company_name'] = 'Unknown Company';
                        $jobData['company_logo'] = null;
                        $jobData['company_verified'] = 0;
                    }
                } else {
                    $jobData['company_name'] = 'Unknown Company';
                    $jobData['company_logo'] = null;
                    $jobData['company_verified'] = 0;
                }
                
                // Get category name if available
                if ($job->category_id) {
                    $category = JobCategory::findOne($job->category_id);
                    $jobData['category'] = $category ? $category->name : 'Uncategorized';
                } else {
                    $jobData['category'] = 'Uncategorized';
                }
                
                $jobsArray[] = $jobData;
            }
            
            // Get all locations for filter dropdown
            $locations = Job::find()
                ->select(['location'])
                ->where(['status' => 'published'])
                ->andWhere(['IS NOT', 'location', null])
                ->andWhere(['<>', 'location', ''])
                ->groupBy(['location'])
                ->orderBy(['location' => SORT_ASC])
                ->column();
                
            // Get all categories for filter dropdown
            $categories = JobCategory::find()
                ->where(['status' => JobCategory::STATUS_ACTIVE])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
                    
            return $this->render('//JobPortal/System/User/jobs/browse', [
                'jobs' => $jobsArray,
                'totalCount' => $totalCount,
                'pagination' => $pagination,
                'filters' => $filters,
                'locations' => $locations,
                'categories' => $categories,
                'title' => 'Browse Jobs',
                'debug' => [
                    'allJobs' => $allJobsCount,
                    'publishedJobs' => $publishedJobsCount,
                    'filteredJobs' => $totalCount,
                    'status_value' => 'published', // Added for debugging
                ]
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionBrowse: " . $e->getMessage());
            Yii::error("Trace: " . $e->getTraceAsString());
            
            return $this->render('//JobPortal/System/User/jobs/browse', [
                'jobs' => [],
                'totalCount' => 0,
                'pagination' => new Pagination(['totalCount' => 0, 'pageSize' => 9]),
                'filters' => $filters ?? [],
                'locations' => [],
                'categories' => [],
                'title' => 'Browse Jobs - Error',
                'error' => "Unable to load jobs. Please make sure jobs have been created by the administrator.\n" . $e->getMessage()
            ]);
        }
    }

    /**
     * View single job details
     * 
     * @param int $id Job ID
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        try {
            // Find job with the specified ID that is published
            $job = Job::find()
                ->where(['id' => $id])
                ->andWhere(['status' => 'published'])
                ->one();
                
            // If job not found or expired, throw 404
            if (!$job || ($job->expires_at && strtotime($job->expires_at) < time())) {
                throw new NotFoundHttpException('The job posting you are looking for does not exist or has expired.');
            }
            
            // Increment view count
            $job->views_count = $job->views_count + 1;
            $job->save(false, ['views_count']);
            
            // Get company details
            $company = $job->company;
            
            // Get category
            $category = $job->category;
            
            // Check if user has applied
            $hasApplied = false;
            if (!Yii::$app->user->isGuest) {
                $hasApplied = JobApplication::find()
                    ->where(['job_id' => $id, 'applicant_id' => Yii::$app->user->id])
                    ->exists();
            }
            
            // Check if job is saved
            $isSaved = false;
            if (!Yii::$app->user->isGuest) {
                $isSaved = SavedJob::find()
                    ->where(['job_id' => $id, 'user_id' => Yii::$app->user->id])
                    ->exists();
            }
            
            // Get similar jobs from the same category
            $similarJobs = Job::find()
                ->where(['status' => 'published', 'category_id' => $job->category_id])
                ->andWhere(['<>', 'id', $job->id]) // Exclude current job
                ->andWhere(['OR', ['expires_at' => null], ['>', 'expires_at', date('Y-m-d H:i:s')]])
                ->limit(3)
                ->all();
                
            return $this->render('//JobPortal/System/User/jobs/view', [
                'job' => $job,
                'company' => $company,
                'category' => $category,
                'hasApplied' => $hasApplied,
                'isSaved' => $isSaved,
                'similarJobs' => $similarJobs,
                'title' => $job->title,
                'pageTitle' => $job->title
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionView: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load job details: ' . $e->getMessage());
            return $this->redirect(['browse']);
        }
    }

    /**
     * Save a job (AJAX)
     */
    public function actionSave($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            // Check if user is logged in
            if (Yii::$app->user->isGuest) {
                return [
                    'success' => false,
                    'message' => 'Please log in to save jobs.',
                    'redirect' => Url::to(['/auth-signin'])
                ];
            }
            
            // Get current user ID
            $userId = Yii::$app->user->id;
            
            // Check if job exists
            $job = Job::findOne($id);
            if (!$job) {
                return [
                    'success' => false,
                    'message' => 'Job not found.'
                ];
            }
            
            // Check if job is already saved
            $savedJob = SavedJob::findOne(['user_id' => $userId, 'job_id' => $id]);
            if ($savedJob) {
                return [
                    'success' => false,
                    'message' => 'This job is already saved.'
                ];
            }
            
            // Create new saved job
            $newSavedJob = new SavedJob();
            $newSavedJob->user_id = $userId;
            $newSavedJob->job_id = $id;
            
            if ($newSavedJob->save()) {
                return [
                    'success' => true,
                    'message' => 'Job saved successfully.'
                ];
            } else {
                // Return validation errors in more detail
                return [
                    'success' => false,
                    'message' => 'Failed to save job: ' . implode(', ', $newSavedJob->getErrorSummary(true)),
                    'errors' => $newSavedJob->getErrors()
                ];
            }
            
        } catch (\Exception $e) {
            // Log the actual exception with detailed information
            Yii::error("Error in JobsController::actionSave: " . $e->getMessage());
            Yii::error("Exception trace: " . $e->getTraceAsString());
            
            // More specific error messages based on exception types
            if ($e instanceof \yii\db\Exception) {
                // Database exceptions
                if (strpos($e->getMessage(), 'Base table or view not found') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Database table "saved_jobs" does not exist. Please check your database setup.',
                        'debug' => YII_DEBUG ? $e->getMessage() : null
                    ];
                } else if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    return [
                        'success' => false,
                        'message' => 'You have already saved this job.',
                        'debug' => YII_DEBUG ? $e->getMessage() : null
                    ];
                } else if (strpos($e->getMessage(), 'Column not found') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Database schema mismatch. Required columns are missing.',
                        'debug' => YII_DEBUG ? $e->getMessage() : null
                    ];
                } else if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Unable to save job: it may have been deleted or you are not properly registered.',
                        'debug' => YII_DEBUG ? $e->getMessage() : null
                    ];
                }
            } else if ($e instanceof \yii\web\ForbiddenHttpException) {
                return [
                    'success' => false,
                    'message' => 'You do not have permission to save this job.',
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            } else if ($e instanceof \yii\web\UnauthorizedHttpException) {
                return [
                    'success' => false,
                    'message' => 'Please log in to save jobs.',
                    'redirect' => Url::to(['/auth-signin']),
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            }
            
            // For CSRF validation errors
            if (strpos($e->getMessage(), 'Unable to verify your data submission') !== false) {
                return [
                    'success' => false,
                    'message' => 'CSRF validation failed. Please refresh the page and try again.',
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            }
            
            // For everything else, show details in development mode
            return [
                'success' => false,
                'message' => YII_DEBUG ? 'Error: ' . $e->getMessage() : 'An error occurred while saving the job. Please try again later.',
                'debug' => YII_DEBUG ? [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ];
        }
    }

    /**
     * Remove a job from user's saved jobs list
     * 
     * @param int $id Job ID
     * @return \yii\web\Response
     */
    public function actionUnsave($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            // Check if user is logged in
            if (Yii::$app->user->isGuest) {
                return [
                    'success' => false,
                    'message' => 'Please log in to manage saved jobs.',
                    'redirect' => Url::to(['/auth-signin'])
                ];
            }
            
            // Get current user ID
            $userId = Yii::$app->user->id;
            
            // Find the saved job record
            $savedJob = SavedJob::findOne(['user_id' => $userId, 'job_id' => $id]);
            
            if (!$savedJob) {
                return [
                    'success' => false,
                    'message' => 'This job was not saved.'
                ];
            }
            
            // Delete the saved job
            if ($savedJob->delete()) {
                return [
                    'success' => true,
                    'message' => 'Job removed from saved jobs.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to remove job from saved jobs.'
                ];
            }
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionUnsave: " . $e->getMessage());
            Yii::error("Exception trace: " . $e->getTraceAsString());
            
            // More specific error messages based on exception types
            if ($e instanceof \yii\db\Exception) {
                if (strpos($e->getMessage(), 'Base table or view not found') !== false) {
                    return [
                        'success' => false,
                        'message' => 'Database table "saved_jobs" does not exist.',
                        'debug' => YII_DEBUG ? $e->getMessage() : null
                    ];
                }
            } else if ($e instanceof \yii\web\ForbiddenHttpException) {
                return [
                    'success' => false,
                    'message' => 'You do not have permission to remove this saved job.',
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            } else if ($e instanceof \yii\web\UnauthorizedHttpException) {
                return [
                    'success' => false,
                    'message' => 'Please log in to manage saved jobs.',
                    'redirect' => Url::to(['/auth-signin']),
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            }
            
            // For CSRF validation errors
            if (strpos($e->getMessage(), 'Unable to verify your data submission') !== false) {
                return [
                    'success' => false,
                    'message' => 'CSRF validation failed. Please refresh the page and try again.',
                    'debug' => YII_DEBUG ? $e->getMessage() : null
                ];
            }
            
            // For everything else, show details in development mode
            return [
                'success' => false,
                'message' => YII_DEBUG ? 'Error: ' . $e->getMessage() : 'An error occurred while removing the saved job. Please try again later.',
                'debug' => YII_DEBUG ? [
                    'error' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ] : null
            ];
        }
    }

    /**
     * Apply for a job
     */
    public function actionApply($id)
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Check if job exists and is published
            $job = $db->createCommand("
                SELECT j.*, c.name as company_name 
                FROM jobs j 
                LEFT JOIN companies c ON j.company_id = c.id 
                WHERE j.id = :id AND j.status = 'published'
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$job) {
                throw new NotFoundHttpException('Job not found or not available');
            }
            
            // Check if already applied
            $existingApplication = $db->createCommand("
                SELECT id FROM job_applications 
                WHERE user_id = :userId AND job_id = :jobId
            ")->bindValues([':userId' => $userId, ':jobId' => $id])->queryScalar();
            
            if ($existingApplication) {
                Yii::$app->session->setFlash('warning', 'You have already applied for this job.');
                return $this->redirect(['view', 'id' => $id]);
            }
            
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post();
                
                // Validate required fields
                if (empty($postData['cover_letter'])) {
                    throw new \Exception('Cover letter is required');
                }
                
                // Handle file upload for resume
                $resumeFile = null;
                if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
                    $uploadDir = Yii::getAlias('@webroot/uploads/resumes/');
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    $fileName = $userId . '_' . time() . '_' . $_FILES['resume']['name'];
                    $filePath = $uploadDir . $fileName;
                    
                    if (move_uploaded_file($_FILES['resume']['tmp_name'], $filePath)) {
                        $resumeFile = 'uploads/resumes/' . $fileName;
                    }
                }
                
                // Insert application
                $db->createCommand()->insert('job_applications', [
                    'job_id' => $id,
                    'user_id' => $userId,
                    'cover_letter' => $postData['cover_letter'],
                    'resume_file' => $resumeFile,
                    'expected_salary' => !empty($postData['expected_salary']) ? $postData['expected_salary'] : null,
                    'availability_date' => !empty($postData['availability_date']) ? $postData['availability_date'] : null,
                    'status' => 'pending',
                    'applied_at' => date('Y-m-d H:i:s')
                ])->execute();
                
                // Update job applications count
                $db->createCommand("UPDATE jobs SET applications_count = applications_count + 1 WHERE id = :id")
                  ->bindValue(':id', $id)
                  ->execute();
                
                Yii::$app->session->setFlash('success', 'Your application has been submitted successfully!');
                return $this->redirect(['view', 'id' => $id]);
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/apply', [
                'job' => $job,
                'title' => 'Apply for ' . $job['title'],
                'pageTitle' => 'Apply for ' . $job['title'] . ' - ' . $job['company_name']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionApply: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to process application: ' . $e->getMessage());
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * View saved jobs
     */
    public function actionSaved()
    {
        try {
            $userId = Yii::$app->user->id;
            
            // Count total saved jobs for pagination
            $totalCount = Yii::$app->db->createCommand("
                SELECT COUNT(*)
                FROM saved_jobs sj 
                JOIN jobs j ON sj.job_id = j.id 
                WHERE sj.user_id = :userId AND j.status = 'published'
            ")->bindValue(':userId', $userId)->queryScalar();
            
            // Setup pagination
            $pagination = new Pagination([
                'totalCount' => $totalCount,
                'pageSize' => 9,
                'page' => (int)Yii::$app->request->get('page', 0),
            ]);
            
            // Modified SQL query with pagination
            $savedJobs = Yii::$app->db->createCommand("
                SELECT j.*, j.id as job_id, c.name as company_name, c.logo as company_logo, 
                       c.verified as company_verified, cat.name as category, 
                       sj.created_at as saved_at, sj.id as saved_id,
                       1 as is_saved, 0 as has_applied
                FROM saved_jobs sj 
                JOIN jobs j ON sj.job_id = j.id 
                LEFT JOIN companies c ON j.company_id = c.id 
                LEFT JOIN job_categories cat ON j.category_id = cat.id 
                WHERE sj.user_id = :userId AND j.status = 'published'
                ORDER BY sj.created_at DESC
                LIMIT {$pagination->limit} OFFSET {$pagination->offset}
            ")->bindValue(':userId', $userId)->queryAll();
            
            return $this->render('@app/views/JobPortal/System/User/jobs/saved', [
                'savedJobs' => $savedJobs,
                'pagination' => $pagination,  // Pass the pagination object to the view
                'totalCount' => $totalCount,
                'title' => 'Saved Jobs',
                'pageTitle' => 'Your Saved Jobs'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionSaved: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load saved jobs: ' . $e->getMessage());
            
            // Also provide an empty pagination object for error case
            return $this->render('@app/views/JobPortal/System/User/jobs/saved', [
                'savedJobs' => [],
                'pagination' => new Pagination(['totalCount' => 0, 'pageSize' => 9]),
                'totalCount' => 0,
                'title' => 'Saved Jobs',
                'pageTitle' => 'Saved Jobs',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * View my applications
     */
    public function actionMyApplications()
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get user's job applications
            $query = "SELECT ja.*, 
                             j.title as job_title,
                             j.slug as job_slug,
                             j.location,
                             j.job_type,
                             j.salary_min,
                             j.salary_max,
                             j.salary_currency,
                             c.name as company_name,
                             c.logo as company_logo,
                             c.verified as company_verified,
                             cat.name as category
                      FROM job_applications ja
                      JOIN jobs j ON ja.job_id = j.id
                      LEFT JOIN companies c ON j.company_id = c.id
                      LEFT JOIN job_categories cat ON j.category_id = cat.id
                      WHERE ja.user_id = :userId
                      ORDER BY ja.applied_at DESC";
            
            // Count total applications
            $totalCount = $db->createCommand("SELECT COUNT(*) FROM job_applications WHERE user_id = :userId")
                            ->bindValue(':userId', $userId)
                            ->queryScalar();
            
            // Setup pagination
            $pagination = new Pagination([
                'totalCount' => $totalCount,
                'pageSize' => 10,
            ]);
            
            // Get applications for current page
            $applications = $db->createCommand($query . " LIMIT {$pagination->limit} OFFSET {$pagination->offset}")
                              ->bindValue(':userId', $userId)
                              ->queryAll();
            
            // Get application statistics
            $stats = $db->createCommand("
                SELECT 
                    status,
                    COUNT(*) as count
                FROM job_applications 
                WHERE user_id = :userId 
                GROUP BY status
            ")->bindValue(':userId', $userId)->queryAll();
            
            $applicationStats = [];
            foreach ($stats as $stat) {
                $applicationStats[$stat['status']] = $stat['count'];
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/my-applications', [
                'applications' => $applications,
                'pagination' => $pagination,
                'totalCount' => $totalCount,
                'applicationStats' => $applicationStats,
                'title' => 'My Applications',
                'pageTitle' => 'My Job Applications'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionMyApplications: " . $e->getMessage());
            return $this->render('@app/views/JobPortal/System/User/jobs/my-applications', [
                'applications' => [],
                'pagination' => new Pagination(['totalCount' => 0, 'pageSize' => 10]),
                'totalCount' => 0,
                'applicationStats' => [],
                'title' => 'My Applications',
                'pageTitle' => 'My Job Applications - Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display all job categories
     */
    public function actionCategories()
    {
        try {
            // Get all active categories
            $categories = JobCategory::find()
                ->where(['status' => 'active']) 
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
                
            // Get trending categories (limit to 6)
            // Modified to remove the featured column reference
            $trendingCategories = JobCategory::find()
                ->where(['status' => 'active'])
                // Remove this line that's causing the error:
                // ->andWhere(['featured' => 1]) 
                ->limit(6)
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
                
            // Count jobs in each trending category
            foreach ($trendingCategories as &$trending) {
                $trending['jobs_count'] = Job::find()
                    ->where(['category_id' => $trending['id'], 'status' => 'published'])
                    ->andWhere(['or', ['expires_at' => null], ['>', 'expires_at', date('Y-m-d H:i:s')]])
                    ->count();
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/categories', [
                'categories' => $categories,
                'trendingCategories' => $trendingCategories,
                'title' => 'Job Categories',
                'pageTitle' => 'Job Categories - Find Jobs by Industry'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionCategories: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load categories: ' . $e->getMessage());
            
            return $this->render('@app/views/JobPortal/System/User/jobs/categories', [
                'categories' => [],
                'trendingCategories' => [],
                'title' => 'Job Categories',
                'pageTitle' => 'Job Categories - Error'
            ]);
        }
    }

    /**
     * Search jobs by category
     */
    public function actionByCategory($slug)
    {
        try {
            $db = Yii::$app->db;
            
            // Get category details
            $category = $db->createCommand("
                SELECT * FROM job_categories 
                WHERE slug = :slug AND status = 'active'
            ")->bindValue(':slug', $slug)->queryOne();
            
            if (!$category) {
                throw new NotFoundHttpException('Category not found');
            }
            
            // Redirect to browse with category filter
            return $this->redirect(['browse', 'category' => $slug]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionByCategory: " . $e->getMessage());
            return $this->redirect(['browse']);
        }
    }

    /**
     * Get job application details (for users to view their own application)
     */
    public function actionViewApplication($id)
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get application details (only user's own applications)
            $application = $db->createCommand("
                SELECT ja.*, 
                       j.title as job_title,
                       j.description as job_description,
                       j.requirements as job_requirements,
                       j.location,
                       j.job_type,
                       j.salary_min,
                       j.salary_max,
                       j.salary_currency,
                       c.name as company_name,
                       c.logo as company_logo,
                       c.verified as company_verified,
                       c.description as company_description,
                       cat.name as category
                FROM job_applications ja
                JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                WHERE ja.id = :id AND ja.user_id = :userId
            ")->bindValues([':id' => $id, ':userId' => $userId])->queryOne();
            
            if (!$application) {
                throw new NotFoundHttpException('Application not found');
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/view-application', [
                'application' => $application,
                'title' => 'Application Details',
                'pageTitle' => 'Application for ' . $application['job_title']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionViewApplication: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Unable to load application details: ' . $e->getMessage());
            return $this->redirect(['my-applications']);
        }
    }

    /**
     * Withdraw job application
     */
    public function actionWithdrawApplication($id)
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Check if application exists and belongs to user
            $application = $db->createCommand("
                SELECT ja.*, j.title as job_title 
                FROM job_applications ja
                JOIN jobs j ON ja.job_id = j.id
                WHERE ja.id = :id AND ja.user_id = :userId AND ja.status = 'pending'
            ")->bindValues([':id' => $id, ':userId' => $userId])->queryOne();
            
            if (!$application) {
                throw new NotFoundHttpException('Application not found or cannot be withdrawn');
            }
            
            if (Yii::$app->request->isPost) {
                // Delete the application
                $db->createCommand()->delete('job_applications', [
                    'id' => $id,
                    'user_id' => $userId
                ])->execute();
                
                // Update job applications count
                $db->createCommand("UPDATE jobs SET applications_count = GREATEST(applications_count - 1, 0) WHERE id = :jobId")
                  ->bindValue(':jobId', $application['job_id'])
                  ->execute();
                
                Yii::$app->session->setFlash('success', 'Your application for "' . $application['job_title'] . '" has been withdrawn.');
                return $this->redirect(['my-applications']);
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/withdraw-application', [
                'application' => $application,
                'title' => 'Withdraw Application',
                'pageTitle' => 'Withdraw Application - ' . $application['job_title']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionWithdrawApplication: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to withdraw application: ' . $e->getMessage());
            return $this->redirect(['my-applications']);
        }
    }

    /**
     * Get job statistics for dashboard
     */
    public function actionStats()
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get user's job statistics
            $stats = [
                'total_applications' => $db->createCommand("SELECT COUNT(*) FROM job_applications WHERE user_id = :userId")
                    ->bindValue(':userId', $userId)->queryScalar(),
                'pending_applications' => $db->createCommand("SELECT COUNT(*) FROM job_applications WHERE user_id = :userId AND status = 'pending'")
                    ->bindValue(':userId', $userId)->queryScalar(),
                'saved_jobs' => $db->createCommand("SELECT COUNT(*) FROM saved_jobs WHERE user_id = :userId")
                    ->bindValue(':userId', $userId)->queryScalar(),
                'total_jobs' => $db->createCommand("SELECT COUNT(*) FROM jobs WHERE status = 'published'")->queryScalar(),
                'new_jobs_this_week' => $db->createCommand("SELECT COUNT(*) FROM jobs WHERE status = 'published' AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->queryScalar(),
            ];
            
            // Get application status breakdown
            $applicationsByStatus = $db->createCommand("
                SELECT status, COUNT(*) as count 
                FROM job_applications 
                WHERE user_id = :userId 
                GROUP BY status
            ")->bindValue(':userId', $userId)->queryAll();
            
            $statusStats = [];
            foreach ($applicationsByStatus as $status) {
                $statusStats[$status['status']] = $status['count'];
            }
            
            // Get recent activity
            $recentApplications = $db->createCommand("
                SELECT ja.applied_at, j.title as job_title, c.name as company_name, ja.status
                FROM job_applications ja
                JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN companies c ON j.company_id = c.id
                WHERE ja.user_id = :userId
                ORDER BY ja.applied_at DESC
                LIMIT 5
            ")->bindValue(':userId', $userId)->queryAll();
            
            return [
                'stats' => $stats,
                'statusStats' => $statusStats,
                'recentApplications' => $recentApplications
            ];
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionStats: " . $e->getMessage());
            return [
                'stats' => [],
                'statusStats' => [],
                'recentApplications' => []
            ];
        }
    }

    /**
     * Search jobs with advanced filters
     */
    public function actionAdvancedSearch()
    {
        try {
            $db = Yii::$app->db;
            
            // Get all available filter options
            $categories = $db->createCommand("
                SELECT id, name, slug FROM job_categories 
                WHERE status = 'active' 
                ORDER BY name
            ")->queryAll();
            
            $companies = $db->createCommand("
                SELECT DISTINCT c.id, c.name 
                FROM companies c
                INNER JOIN jobs j ON c.id = j.company_id
                WHERE c.status = 'active' AND j.status = 'published'
                ORDER BY c.name
            ")->queryAll();
            
            $locations = $db->createCommand("
                SELECT DISTINCT 
                    CASE 
                        WHEN city IS NOT NULL AND city != '' THEN city
                        ELSE location 
                    END as location
                FROM jobs 
                WHERE status = 'published' 
                    AND (city IS NOT NULL AND city != '' OR location IS NOT NULL AND location != '')
                ORDER BY location
            ")->queryColumn();
            
            $skills = $db->createCommand("
                SELECT DISTINCT s.id, s.name 
                FROM skills s
                INNER JOIN job_skills js ON s.id = js.skill_id
                INNER JOIN jobs j ON js.job_id = j.id
                WHERE s.status = 'active' AND j.status = 'published'
                ORDER BY s.name
            ")->queryAll();
            
            return $this->render('@app/views/JobPortal/System/User/jobs/advanced-search', [
                'categories' => $categories,
                'companies' => $companies,
                'locations' => $locations,
                'skills' => $skills,
                'title' => 'Advanced Job Search',
                'pageTitle' => 'Advanced Job Search'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionAdvancedSearch: " . $e->getMessage());
            return $this->render('@app/views/JobPortal/System/User/jobs/advanced-search', [
                'categories' => [],
                'companies' => [],
                'locations' => [],
                'skills' => [],
                'title' => 'Advanced Job Search',
                'pageTitle' => 'Advanced Job Search - Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get job alerts/recommendations for user
     */
    public function actionRecommendations()
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get user's application history to understand preferences
            $userPreferences = $db->createCommand("
                SELECT 
                    j.category_id,
                    j.job_type,
                    j.location_type,
                    j.experience_level,
                    COUNT(*) as frequency
                FROM job_applications ja
                JOIN jobs j ON ja.job_id = j.id
                WHERE ja.user_id = :userId
                GROUP BY j.category_id, j.job_type, j.location_type, j.experience_level
                ORDER BY frequency DESC
                LIMIT 5
            ")->bindValue(':userId', $userId)->queryAll();
            
            // Get recommended jobs based on user preferences
            $recommendedJobs = [];
            if (!empty($userPreferences)) {
                $preference = $userPreferences[0]; // Use most frequent preference
                
                $recommendedJobs = $db->createCommand("
                    SELECT j.*, 
                           c.name as company_name, 
                           c.logo as company_logo, 
                           c.verified as company_verified,
                           cat.name as category,
                           0 as is_saved,
                           0 as has_applied
                    FROM jobs j 
                    LEFT JOIN companies c ON j.company_id = c.id
                    LEFT JOIN job_categories cat ON j.category_id = cat.id
                    WHERE j.status = 'published'
                        AND (j.expires_at IS NULL OR j.expires_at > NOW())
                        AND j.id NOT IN (SELECT job_id FROM job_applications WHERE user_id = :userId)
                        AND (
                            j.category_id = :categoryId 
                            OR j.job_type = :jobType 
                            OR j.location_type = :locationType 
                            OR j.experience_level = :experienceLevel
                        )
                    ORDER BY j.created_at DESC
                    LIMIT 10
                ")->bindValues([
                    ':userId' => $userId,
                    ':categoryId' => $preference['category_id'],
                    ':jobType' => $preference['job_type'],
                    ':locationType' => $preference['location_type'],
                    ':experienceLevel' => $preference['experience_level']
                ])->queryAll();
            }
            
            // If no preferences or no recommended jobs, get latest jobs
            if (empty($recommendedJobs)) {
                $recommendedJobs = $db->createCommand("
                    SELECT j.*, 
                           c.name as company_name, 
                           c.logo as company_logo, 
                           c.verified as company_verified,
                           cat.name as category,
                           0 as is_saved,
                           0 as has_applied
                    FROM jobs j 
                    LEFT JOIN companies c ON j.company_id = c.id
                    LEFT JOIN job_categories cat ON j.category_id = cat.id
                    WHERE j.status = 'published'
                        AND (j.expires_at IS NULL OR j.expires_at > NOW())
                        AND j.id NOT IN (SELECT job_id FROM job_applications WHERE user_id = :userId)
                    ORDER BY j.created_at DESC
                    LIMIT 10
                ")->bindValue(':userId', $userId)->queryAll();
            }
            
            return $this->render('@app/views/JobPortal/System/User/jobs/recommendations', [
                'recommendedJobs' => $recommendedJobs,
                'userPreferences' => $userPreferences,
                'title' => 'Job Recommendations',
                'pageTitle' => 'Recommended Jobs for You'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionRecommendations: " . $e->getMessage());
            return $this->render('@app/views/JobPortal/System/User/jobs/recommendations', [
                'recommendedJobs' => [],
                'userPreferences' => [],
                'title' => 'Job Recommendations',
                'pageTitle' => 'Recommended Jobs for You - Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Search jobs by company
     */
    public function actionByCompany($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company details
            $company = $db->createCommand("
                SELECT * FROM companies 
                WHERE id = :id AND status = 'active'
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
            
            // Get jobs from this company
            $jobs = $db->createCommand("
                SELECT j.*, 
                       c.name as company_name, 
                       c.logo as company_logo, 
                       c.verified as company_verified,
                       cat.name as category,
                       0 as is_saved,
                       0 as has_applied
                FROM jobs j 
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                WHERE j.company_id = :companyId 
                    AND j.status = 'published'
                    AND (j.expires_at IS NULL OR j.expires_at > NOW())
                ORDER BY j.created_at DESC
            ")->bindValue(':companyId', $id)->queryAll();
            
            return $this->render('@app/views/JobPortal/System/User/jobs/by-company', [
                'company' => $company,
                'jobs' => $jobs,
                'title' => 'Jobs at ' . $company['name'],
                'pageTitle' => 'Jobs at ' . $company['name']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionByCompany: " . $e->getMessage());
            return $this->redirect(['browse']);
        }
    }

    /**
     * Get job alerts based on user preferences
     */
    public function actionAlerts()
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get new jobs posted in last 7 days that match user's previous applications
            $newJobs = $db->createCommand("
                SELECT DISTINCT j.*, 
                       c.name as company_name, 
                       c.logo as company_logo, 
                       c.verified as company_verified,
                       cat.name as category
                FROM jobs j 
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                WHERE j.status = 'published'
                    AND j.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                    AND (j.expires_at IS NULL OR j.expires_at > NOW())
                    AND j.id NOT IN (SELECT job_id FROM job_applications WHERE user_id = :userId)
                    AND (
                        j.category_id IN (
                            SELECT DISTINCT j2.category_id 
                            FROM job_applications ja2 
                            JOIN jobs j2 ON ja2.job_id = j2.id 
                            WHERE ja2.user_id = :userId
                        )
                        OR j.job_type IN (
                            SELECT DISTINCT j3.job_type 
                            FROM job_applications ja3 
                            JOIN jobs j3 ON ja3.job_id = j3.id 
                            WHERE ja3.user_id = :userId
                        )
                    )
                ORDER BY j.created_at DESC
                LIMIT 20
            ")->bindValue(':userId', $userId)->queryAll();
            
            return $this->render('@app/views/JobPortal/System/User/jobs/alerts', [
                'newJobs' => $newJobs,
                'title' => 'Job Alerts',
                'pageTitle' => 'New Job Alerts for You'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionAlerts: " . $e->getMessage());
            return $this->render('@app/views/JobPortal/System/User/jobs/alerts', [
                'newJobs' => [],
                'title' => 'Job Alerts',
                'pageTitle' => 'New Job Alerts for You - Error',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Export user's applications to PDF/Excel
     */
    public function actionExportApplications($format = 'pdf')
    {
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Get user's applications
            $applications = $db->createCommand("
                SELECT ja.*, 
                       j.title as job_title,
                       j.location,
                       j.job_type,
                       j.salary_min,
                       j.salary_max,
                       c.name as company_name,
                       cat.name as category
                FROM job_applications ja
                JOIN jobs j ON ja.job_id = j.id
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                WHERE ja.user_id = :userId
                ORDER BY ja.applied_at DESC
            ")->bindValue(':userId', $userId)->queryAll();
            
            if ($format === 'csv') {
                // Export as CSV
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="my_applications.csv"');
                
                $output = fopen('php://output', 'w');
                
                // CSV headers
                fputcsv($output, [
                    'Job Title', 'Company', 'Category', 'Location', 'Job Type', 
                    'Salary Range', 'Applied Date', 'Status'
                ]);
                
                // CSV data
                foreach ($applications as $app) {
                    $salaryRange = '';
                    if ($app['salary_min'] || $app['salary_max']) {
                        $salaryRange = 'TSH ' . number_format($app['salary_min'] ?: 0) . 
                                     ' - ' . number_format($app['salary_max'] ?: 0);
                    }
                    
                    fputcsv($output, [
                        $app['job_title'],
                        $app['company_name'],
                        $app['category'],
                        $app['location'],
                        ucfirst(str_replace('-', ' ', $app['job_type'])),
                        $salaryRange,
                        date('Y-m-d', strtotime($app['applied_at'])),
                        ucfirst($app['status'])
                    ]);
                }
                
                fclose($output);
                exit;
            }
            
            // Default: render as HTML for PDF generation
            return $this->render('@app/views/JobPortal/System/User/jobs/export-applications', [
                'applications' => $applications,
                'title' => 'My Job Applications Export',
                'pageTitle' => 'Export Applications'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionExportApplications: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to export applications: ' . $e->getMessage());
            return $this->redirect(['my-applications']);
        }
    }

    /**
     * Get job details for AJAX requests
     */
    public function actionGetJobDetails($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $db = Yii::$app->db;
            
            $job = $db->createCommand("
                SELECT j.*, 
                       c.name as company_name, 
                       c.logo as company_logo, 
                       c.verified as company_verified,
                       cat.name as category_name
                FROM jobs j 
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                WHERE j.id = :id AND j.status = 'published'
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$job) {
                return ['success' => false, 'message' => 'Job not found'];
            }
            
            return ['success' => true, 'job' => $job];
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionGetJobDetails: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load job details'];
        }
    }

    /**
     * Quick apply for a job (AJAX)
     */
    public function actionQuickApply($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            // Check if job exists and is published
            $job = $db->createCommand("SELECT title FROM jobs WHERE id = :id AND status = 'published'")
                     ->bindValue(':id', $id)
                     ->queryOne();
            
            if (!$job) {
                return ['success' => false, 'message' => 'Job not found'];
            }
            
            // Check if already applied
            $existing = $db->createCommand("SELECT id FROM job_applications WHERE user_id = :userId AND job_id = :jobId")
                          ->bindValues([':userId' => $userId, ':jobId' => $id])
                          ->queryScalar();
            
            if ($existing) {
                return ['success' => false, 'message' => 'You have already applied for this job'];
            }
            
            $postData = Yii::$app->request->post();
            
            // Insert quick application
            $db->createCommand()->insert('job_applications', [
                'job_id' => $id,
                'user_id' => $userId,
                'cover_letter' => $postData['cover_letter'] ?? 'Quick application submitted.',
                'status' => 'pending',
                'applied_at' => date('Y-m-d H:i:s')
            ])->execute();
            
            // Update job applications count
            $db->createCommand("UPDATE jobs SET applications_count = applications_count + 1 WHERE id = :id")
              ->bindValue(':id', $id)
              ->execute();
            
            return ['success' => true, 'message' => 'Application submitted successfully!'];
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionQuickApply: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to submit application'];
        }
    }

    /**
     * Get similar jobs based on current job
     */
    public function actionGetSimilarJobs($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $db = Yii::$app->db;
            
            // Get current job details
            $currentJob = $db->createCommand("SELECT category_id, location, job_type FROM jobs WHERE id = :id")
                            ->bindValue(':id', $id)
                            ->queryOne();
            
            if (!$currentJob) {
                return ['success' => false, 'message' => 'Job not found'];
            }
            
            // Get similar jobs
            $similarJobs = $db->createCommand("
                SELECT j.id, j.title, j.location, j.salary_min, j.salary_max,
                       c.name as company_name, c.logo as company_logo
                FROM jobs j 
                LEFT JOIN companies c ON j.company_id = c.id
                WHERE j.id != :id 
                    AND j.status = 'published'
                    AND (j.expires_at IS NULL OR j.expires_at > NOW())
                    AND (j.category_id = :categoryId OR j.location = :location OR j.job_type = :jobType)
                ORDER BY 
                    CASE WHEN j.category_id = :categoryId THEN 1 ELSE 2 END,
                    j.created_at DESC
                LIMIT 5
            ")->bindValues([
                ':id' => $id,
                ':categoryId' => $currentJob['category_id'],
                ':location' => $currentJob['location'],
                ':jobType' => $currentJob['job_type']
            ])->queryAll();
            
            return ['success' => true, 'jobs' => $similarJobs];
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionGetSimilarJobs: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to load similar jobs'];
        }   
    }
    
    /**
     * Report a job
     */
    public function actionReportJob($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $db = Yii::$app->db;
            $userId = Yii::$app->user->id;
            
            if (Yii::$app->request->isPost) {
                $reason = Yii::$app->request->post('reason', '');
                $description = Yii::$app->request->post('description', '');
                
                if (empty($reason)) {
                    return ['success' => false, 'message' => 'Please select a reason for reporting'];
                }
                
                // Check if job exists
                $job = $db->createCommand("SELECT title FROM jobs WHERE id = :id")
                         ->bindValue(':id', $id)
                         ->queryOne();
                
                if (!$job) {
                    return ['success' => false, 'message' => 'Job not found'];
                }
                
                // Insert job report (you might want to create a job_reports table)
                // For now, we'll just log it
                Yii::info("Job reported - ID: {$id}, User: {$userId}, Reason: {$reason}, Description: {$description}");
                
                return ['success' => true, 'message' => 'Job reported successfully. We will review it shortly.'];
            }
            
            return ['success' => false, 'message' => 'Invalid request'];
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionReportJob: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to report job'];
        }
    }
}




