<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class JobsController extends Controller
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
                    'toggle-status' => ['POST'],
                    'approve' => ['POST'],
                    'reject' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Display all jobs
     */
    public function actionAll() 
    {
        return $this->actionIndex('all');
    }

    /**
     * Display active jobs
     */
    public function actionActive() 
    {
        return $this->actionIndex('active');
    }

    /**
     * Display pending jobs
     */
    public function actionPending() 
    {
        return $this->actionIndex('pending');
    }

    /**
     * Display expired jobs
     */
    public function actionExpired() 
    {
        return $this->actionIndex('expired');
    }

    /**
     * Display reported jobs
     */
    public function actionReported() 
    {
        return $this->actionIndex('reported');
    }

    /**
     * Main index action with filtering
     */
    public function actionIndex($filter = 'all') 
    {
        try {
            $db = Yii::$app->db;
            
            // Check if jobs table exists
            try {
                $db->createCommand("SELECT 1 FROM jobs LIMIT 1")->queryScalar();
            } catch (\Exception $e) {
                // Create jobs table if it doesn't exist
                $this->createJobsTable();
            }
            
            // Build base query - Updated to use your user table
            $baseQuery = "SELECT 
                            j.id,
                            j.title,
                            j.slug,
                            j.description,
                            j.short_description,
                            j.job_type,
                            j.location_type,
                            j.location,
                            j.salary_min,
                            j.salary_max,
                            j.salary_currency,
                            j.experience_level,
                            j.status,
                            j.featured,
                            j.views_count,
                            j.applications_count,
                            j.expires_at,
                            j.created_at,
                            j.updated_at,
                            c.name as company_name,
                            cat.name as category_name,
                            CONCAT(u.firstname, ' ', u.lastname) as posted_by,
                            u.email as poster_email
                          FROM jobs j
                          LEFT JOIN companies c ON j.company_id = c.id
                          LEFT JOIN job_categories cat ON j.category_id = cat.id
                          LEFT JOIN user u ON j.posted_by = u.id";
            
            // Add filtering conditions
            $whereConditions = [];
            $params = [];
            
            switch ($filter) {
                case 'active':
                    $whereConditions[] = "j.status = 'published'";
                    $whereConditions[] = "(j.expires_at IS NULL OR j.expires_at > NOW())";
                    break;
                case 'pending':
                    $whereConditions[] = "j.status = 'pending'";
                    break;
                case 'expired':
                    $whereConditions[] = "(j.expires_at IS NOT NULL AND j.expires_at <= NOW()) OR j.status = 'expired'";
                    break;
                case 'reported':
                    $whereConditions[] = "j.status = 'reported'";
                    break;
                case 'all':
                default:
                    // No additional conditions for 'all'
                    break;
            }
            
            // Build final query
            $query = $baseQuery;
            if (!empty($whereConditions)) {
                $query .= " WHERE " . implode(" AND ", $whereConditions);
            }
            $query .= " ORDER BY j.created_at DESC";
            
            $jobs = $db->createCommand($query)->bindValues($params)->queryAll();
            
            // Calculate statistics
            $allJobs = $db->createCommand("SELECT COUNT(*) FROM jobs")->queryScalar();
            $activeJobs = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE status = 'published' AND (expires_at IS NULL OR expires_at > NOW())")->queryScalar();
            $pendingJobs = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE status = 'pending'")->queryScalar();
            $expiredJobs = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE (expires_at IS NOT NULL AND expires_at <= NOW()) OR status = 'expired'")->queryScalar();
            $reportedJobs = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE status = 'reported'")->queryScalar();
            
            return $this->render('//JobPortal/System/Admin/jobs/list', [
                'jobs' => $jobs,
                'filter' => $filter,
                'allJobs' => $allJobs,
                'activeJobs' => $activeJobs,
                'pendingJobs' => $pendingJobs,
                'expiredJobs' => $expiredJobs,
                'reportedJobs' => $reportedJobs,
                'title' => ucfirst($filter) . ' Jobs',
                'pageTitle' => 'Jobs Management - ' . ucfirst($filter)
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionIndex: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load jobs: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/jobs/list', [
                'jobs' => [],
                'filter' => $filter,
                'allJobs' => 0,
                'activeJobs' => 0,
                'pendingJobs' => 0,
                'expiredJobs' => 0,
                'reportedJobs' => 0,
                'title' => ucfirst($filter) . ' Jobs',
                'pageTitle' => 'Jobs Management - ' . ucfirst($filter)
            ]);
        }
    }

    /**
     * View job details
     */
    public function actionView($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get job with all related information - Updated to use your user table
            $job = $db->createCommand("
                SELECT j.*, 
                       c.name as company_name,
                       c.logo as company_logo,
                       c.website as company_website,
                       cat.name as category_name,
                       CONCAT(u.firstname, ' ', u.lastname) as posted_by,
                       u.email as poster_email
                FROM jobs j
                LEFT JOIN companies c ON j.company_id = c.id
                LEFT JOIN job_categories cat ON j.category_id = cat.id
                LEFT JOIN user u ON j.posted_by = u.id
                WHERE j.id = :id
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$job) {
                throw new NotFoundHttpException('Job not found');
            }
            
            // Get job skills
            $skills = $db->createCommand("
                SELECT s.name, s.id 
                FROM job_skills js 
                JOIN skills s ON js.skill_id = s.id 
                WHERE js.job_id = :job_id
            ")->bindValue(':job_id', $id)->queryAll();
            
            // Get applications count by status
            $applicationStats = $db->createCommand("
                SELECT 
                    status,
                    COUNT(*) as count
                FROM job_applications 
                WHERE job_id = :job_id 
                GROUP BY status
            ")->bindValue(':job_id', $id)->queryAll();
            
            return $this->render('//JobPortal/System/Admin/jobs/view', [
                'job' => $job,
                'skills' => $skills,
                'applicationStats' => $applicationStats,
                'title' => 'Job Details',
                'pageTitle' => 'Job: ' . $job['title']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in JobsController::actionView: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load job: ' . $e->getMessage());
            return $this->redirect(['all']);
        }
    }

    /**
     * Approve pending job
     */
    public function actionApprove($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                
                // Check if job exists and is pending
                $job = $db->createCommand("SELECT title, status FROM jobs WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$job) {
                    throw new NotFoundHttpException('Job not found');
                }
                
                if ($job['status'] !== 'pending') {
                    throw new \Exception('Only pending jobs can be approved');
                }
                
                // Update status to published
                $db->createCommand()->update('jobs', [
                    'status' => 'published',
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Job "' . $job['title'] . '" approved successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionApprove: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to approve job: ' . $e->getMessage());
        }
        
        return $this->redirect(['pending']);
    }

    /**
     * Reject pending job
     */
    public function actionReject($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                $reason = Yii::$app->request->post('reason', '');
                
                // Check if job exists
                $job = $db->createCommand("SELECT title, status FROM jobs WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$job) {
                    throw new NotFoundHttpException('Job not found');
                }
                
                // Update status to rejected
                $db->createCommand()->update('jobs', [
                    'status' => 'rejected',
                    'rejection_reason' => $reason,
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Job "' . $job['title'] . '" rejected successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionReject: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to reject job: ' . $e->getMessage());
        }
        
        return $this->redirect(['pending']);
    }

    /**
     * Toggle job status
     */
    public function actionToggleStatus($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                $status = Yii::$app->request->post('status');
                
                $allowedStatuses = ['published', 'draft', 'expired', 'reported'];
                if (!in_array($status, $allowedStatuses)) {
                    throw new \Exception('Invalid status');
                }
                
                // Check if job exists
                $job = $db->createCommand("SELECT title FROM jobs WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$job) {
                    throw new NotFoundHttpException('Job not found');
                }
                
                // Update status
                $db->createCommand()->update('jobs', [
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Job "' . $job['title'] . '" status updated to ' . $status . ' successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionToggleStatus: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update job status: ' . $e->getMessage());
        }
        
        return $this->redirect(['all']);
    }

    /**
     * Delete job
     */
    public function actionDelete($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                
                // Check if job exists
                $job = $db->createCommand("SELECT title FROM jobs WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$job) {
                    throw new NotFoundHttpException('Job not found');
                }
                
                // Delete related records first
                $db->createCommand()->delete('job_skills', ['job_id' => $id])->execute();
                $db->createCommand()->delete('job_applications', ['job_id' => $id])->execute();
                
                // Delete the job
                $db->createCommand()->delete('jobs', ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Job "' . $job['title'] . '" deleted successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionDelete: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to delete job: ' . $e->getMessage());
        }
        
        return $this->redirect(['all']);
    }

    /**
     * Create jobs table and related tables if they don't exist
     */
    private function createJobsTable()
    {
        $db = Yii::$app->db;
        
        // Create companies table first
        $companiesSql = "CREATE TABLE IF NOT EXISTS companies (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT,
            logo VARCHAR(255),
            website VARCHAR(255),
            email VARCHAR(255),
            phone VARCHAR(50),
            address TEXT,
            city VARCHAR(100),
            country VARCHAR(100),
            size_range VARCHAR(50),
            industry VARCHAR(100),
            founded_year INT,
            status ENUM('active', 'inactive', 'pending', 'suspended') DEFAULT 'pending',
            verified BOOLEAN DEFAULT FALSE,
            featured BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_status (status),
            INDEX idx_verified (verified),
            INDEX idx_featured (featured)
        )";
        
        // Create jobs table
        $jobsSql = "CREATE TABLE IF NOT EXISTS jobs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description LONGTEXT NOT NULL,
            short_description TEXT,
            requirements TEXT,
            benefits TEXT,
            
            company_id INT,
            category_id INT,
            posted_by INT,
            
            job_type ENUM('full-time', 'part-time', 'contract', 'freelance', 'internship', 'temporary') DEFAULT 'full-time',
            location_type ENUM('onsite', 'remote', 'hybrid') DEFAULT 'onsite',
            location VARCHAR(255),
            
            salary_min DECIMAL(12,2),
            salary_max DECIMAL(12,2),
            salary_currency VARCHAR(3) DEFAULT 'USD',
            salary_period ENUM('hourly', 'daily', 'weekly', 'monthly', 'yearly') DEFAULT 'monthly',
            
            experience_level ENUM('entry', 'junior', 'mid', 'senior', 'lead', 'executive') DEFAULT 'mid',
            education_level ENUM('high-school', 'diploma', 'bachelor', 'master', 'phd', 'other') DEFAULT 'bachelor',
            
            status ENUM('draft', 'pending', 'published', 'expired', 'rejected', 'reported') DEFAULT 'pending',
            featured BOOLEAN DEFAULT FALSE,
            urgent BOOLEAN DEFAULT FALSE,
            
            views_count INT DEFAULT 0,
            applications_count INT DEFAULT 0,
            
            expires_at DATETIME,
            rejection_reason TEXT,
            
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            INDEX idx_status (status),
            INDEX idx_company_id (company_id),
            INDEX idx_category_id (category_id),
            INDEX idx_job_type (job_type),
            INDEX idx_location_type (location_type),
            INDEX idx_featured (featured),
            INDEX idx_expires_at (expires_at),
            INDEX idx_created_at (created_at),
            
            FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL,
            FOREIGN KEY (category_id) REFERENCES job_categories(id) ON DELETE SET NULL
        )";
        
        // Create job_skills junction table
        $jobSkillsSql = "CREATE TABLE IF NOT EXISTS job_skills (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_id INT NOT NULL,
            skill_id INT NOT NULL,
            required BOOLEAN DEFAULT TRUE,
            proficiency_level ENUM('basic', 'intermediate', 'advanced', 'expert') DEFAULT 'intermediate',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            
            UNIQUE KEY unique_job_skill (job_id, skill_id),
            INDEX idx_job_id (job_id),
            INDEX idx_skill_id (skill_id),
            
            FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
            FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE
        )";
        
        // Create job_applications table
        $applicationsSql = "CREATE TABLE IF NOT EXISTS job_applications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            job_id INT NOT NULL,
            applicant_id INT NOT NULL,
            
            cover_letter TEXT,
            resume_file VARCHAR(255),
            expected_salary DECIMAL(12,2),
            availability_date DATE,
            
            status ENUM('pending', 'reviewed', 'shortlisted', 'interviewed', 'offered', 'hired', 'rejected') DEFAULT 'pending',
            notes TEXT,
            
            applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            UNIQUE KEY unique_application (job_id, applicant_id),
            INDEX idx_job_id (job_id),
            INDEX idx_applicant_id (applicant_id),
            INDEX idx_status (status),
            INDEX idx_applied_at (applied_at),
            
            FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
        )";
        
        // Execute table creation
        $db->createCommand($companiesSql)->execute();
        $db->createCommand($jobsSql)->execute();
        $db->createCommand($jobSkillsSql)->execute();
        $db->createCommand($applicationsSql)->execute();
        
        // Insert sample data
        $this->insertSampleData();
    }

    /**
     * Insert sample data for testing
     */
    private function insertSampleData()
    {
        $db = Yii::$app->db;
        
        // Insert sample companies
        $companies = [
            ['TechCorp Ltd', 'techcorp-ltd', 'Leading technology company', 'active', 1],
            ['StartupVenture Inc', 'startupventure-inc', 'Innovative startup company', 'active', 1],
            ['Global Solutions', 'global-solutions', 'International consulting firm', 'pending', 0],
        ];
        
        foreach ($companies as $company) {
            $existingCompany = $db->createCommand("SELECT id FROM companies WHERE slug = :slug")->bindValue(':slug', $company[1])->queryScalar();
            if (!$existingCompany) {
                $db->createCommand()->insert('companies', [
                    'name' => $company[0],
                    'slug' => $company[1],
                    'description' => $company[2],
                    'status' => $company[3],
                    'verified' => $company[4],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ])->execute();
            }
        }
        
        // Insert sample jobs
        $jobs = [
            [
                'title' => 'Senior PHP Developer',
                'slug' => 'senior-php-developer-' . time(),
                'description' => 'We are looking for a Senior PHP Developer to join our growing team...',
                'short_description' => 'Senior PHP Developer position with competitive salary',
                'job_type' => 'full-time',
                'location_type' => 'hybrid',
                'location' => 'New York, NY',
                'salary_min' => 80000,
                'salary_max' => 120000,
                'experience_level' => 'senior',
                'status' => 'published'
            ],
            [
                'title' => 'Frontend React Developer',
                'slug' => 'frontend-react-developer-' . time(),
                'description' => 'Join our frontend team as a React Developer...',
                'short_description' => 'React Developer for modern web applications',
                'job_type' => 'full-time',
                'location_type' => 'remote',
                'location' => 'Remote',
                'salary_min' => 60000,
                'salary_max' => 90000,
                'experience_level' => 'mid',
                'status' => 'pending'
            ],
            [
                'title' => 'DevOps Engineer',
                'slug' => 'devops-engineer-' . time(),
                'description' => 'We need a DevOps Engineer to manage our infrastructure...',
                'short_description' => 'DevOps Engineer for cloud infrastructure',
                'job_type' => 'full-time',
                'location_type' => 'onsite',
                'location' => 'San Francisco, CA',
                'salary_min' => 90000,
                'salary_max' => 140000,
                'experience_level' => 'senior',
                'status' => 'expired',
                'expires_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];
        
        foreach ($jobs as $job) {
            $existingJob = $db->createCommand("SELECT id FROM jobs WHERE slug = :slug")->bindValue(':slug', $job['slug'])->queryScalar();
            if (!$existingJob) {
                // Get random company ID
                $companyId = $db->createCommand("SELECT id FROM companies ORDER BY RAND() LIMIT 1")->queryScalar();
                $categoryId = $db->createCommand("SELECT id FROM job_categories ORDER BY RAND() LIMIT 1")->queryScalar();
                
                $job['company_id'] = $companyId;
                $job['category_id'] = $categoryId;
                $job['created_at'] = date('Y-m-d H:i:s');
                $job['updated_at'] = date('Y-m-d H:i:s');
                
                $db->createCommand()->insert('jobs', $job)->execute();
            }
        }
    }

    /**
     * Create new job
     */
    public function actionCreate()
    {
        try {
            $db = Yii::$app->db;
            
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post();
                
                // Validate required fields
                $requiredFields = ['title', 'description', 'job_type', 'location_type', 'experience_level'];
                foreach ($requiredFields as $field) {
                    if (empty($postData[$field])) {
                        throw new \Exception("Field '$field' is required");
                    }
                }
                
                // Generate slug
                $slug = $this->generateSlug($postData['title']);
                
                // Prepare job data
                $jobData = [
                    'title' => $postData['title'],
                    'slug' => $slug,
                    'description' => $postData['description'],
                    'short_description' => $postData['short_description'] ?? '',
                    'requirements' => $postData['requirements'] ?? '',
                    'benefits' => $postData['benefits'] ?? '',
                    'company_id' => !empty($postData['company_id']) ? $postData['company_id'] : null,
                    'category_id' => !empty($postData['category_id']) ? $postData['category_id'] : null,
                    'posted_by' => Yii::$app->user->id,
                    'job_type' => $postData['job_type'],
                    'location_type' => $postData['location_type'],
                    'location' => $postData['location'] ?? '',
                    'salary_min' => !empty($postData['salary_min']) ? $postData['salary_min'] : null,
                    'salary_max' => !empty($postData['salary_max']) ? $postData['salary_max'] : null,
                    'salary_currency' => $postData['salary_currency'] ?? 'USD',
                    'salary_period' => $postData['salary_period'] ?? 'monthly',
                    'experience_level' => $postData['experience_level'],
                    'education_level' => $postData['education_level'] ?? 'bachelor',
                    'status' => $postData['status'] ?? 'pending',
                    'featured' => isset($postData['featured']) ? 1 : 0,
                    'urgent' => isset($postData['urgent']) ? 1 : 0,
                    'expires_at' => !empty($postData['expires_at']) ? $postData['expires_at'] : null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Insert job
                $db->createCommand()->insert('jobs', $jobData)->execute();
                $jobId = $db->getLastInsertID();
                
                Yii::$app->session->setFlash('success', 'Job "' . $jobData['title'] . '" created successfully!');
                return $this->redirect(['view', 'id' => $jobId]);
            }
            
            // Get companies and categories for dropdowns
            $companies = $db->createCommand("SELECT id, name FROM companies WHERE status = 'active' ORDER BY name")->queryAll();
            $categories = [];
            try {
                $categories = $db->createCommand("SELECT id, name FROM job_categories WHERE status = 'active' ORDER BY name")->queryAll();
            } catch (\Exception $e) {
                // Categories table might not exist
            }
            
            return $this->render('//JobPortal/System/Admin/jobs/create', [
                'companies' => $companies,
                'categories' => $categories,
                'title' => 'Create New Job',
                'pageTitle' => 'Create Job'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in JobsController::actionCreate: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to create job: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/jobs/create', [
                'companies' => [],
                'categories' => [],
                'title' => 'Create New Job',
                'pageTitle' => 'Create Job'
            ]);
        }
    }

    /**
     * Generate unique slug from title
     */
    private function generateSlug($title)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
        $originalSlug = $slug;
        $counter = 1;
        
        $db = Yii::$app->db;
        while ($db->createCommand("SELECT id FROM jobs WHERE slug = :slug")->bindValue(':slug', $slug)->queryScalar()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}