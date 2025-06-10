<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

class CompaniesController extends Controller
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
                    'verify' => ['POST', 'GET'],  // Allow both POST and GET
                    'feature' => ['POST', 'GET'], // Allow both POST and GET
                    'approve' => ['POST', 'GET'], // Allow both POST and GET
                ],
            ],
        ];
    }

    /**
     * Display all companies
     */
    public function actionAll() 
    {
        return $this->actionIndex('all');
    }

    /**
     * Display verified companies
     */
    public function actionVerified() 
    {
        return $this->actionIndex('verified');
    }

    /**
     * Display pending companies
     */
    public function actionPending() 
    {
        return $this->actionIndex('pending');
    }

    /**
     * Display featured companies
     */
    public function actionFeatured() 
    {
        return $this->actionIndex('featured');
    }

    /**
     * Main index action with filtering
     */
    public function actionIndex($filter = 'all') 
    {
        try {
            $db = Yii::$app->db;
            
            // Check if companies table exists
            try {
                $db->createCommand("SELECT 1 FROM companies LIMIT 1")->queryScalar();
            } catch (\Exception $e) {
                // Create companies table if it doesn't exist
                $this->createCompaniesTable();
            }
            
            // Build base query
            $baseQuery = "SELECT 
                            c.id,
                            c.name,
                            c.slug,
                            c.description,
                            c.logo,
                            c.website,
                            c.email,
                            c.phone,
                            c.address,
                            c.city,
                            c.country,
                            c.size_range,
                            c.industry,
                            c.founded_year,
                            c.status,
                            c.verified,
                            c.featured,
                            c.created_at,
                            c.updated_at,
                            (SELECT COUNT(*) FROM jobs WHERE company_id = c.id) as jobs_count
                          FROM companies c";
            
            // Add filtering conditions
            $whereConditions = [];
            $params = [];
            
            switch ($filter) {
                case 'verified':
                    $whereConditions[] = "c.verified = 1";
                    break;
                case 'pending':
                    $whereConditions[] = "c.status = 'pending'";
                    break;
                case 'featured':
                    $whereConditions[] = "c.featured = 1";
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
            $query .= " ORDER BY c.created_at DESC";
            
            $companies = $db->createCommand($query)->bindValues($params)->queryAll();
            
            // Calculate statistics
            $allCompanies = $db->createCommand("SELECT COUNT(*) FROM companies")->queryScalar();
            $verifiedCompanies = $db->createCommand("SELECT COUNT(*) FROM companies WHERE verified = 1")->queryScalar();
            $pendingCompanies = $db->createCommand("SELECT COUNT(*) FROM companies WHERE status = 'pending'")->queryScalar();
            $featuredCompanies = $db->createCommand("SELECT COUNT(*) FROM companies WHERE featured = 1")->queryScalar();
            
            return $this->render('//JobPortal/System/Admin/companies/list', [
                'companies' => $companies,
                'filter' => $filter,
                'allCompanies' => $allCompanies,
                'verifiedCompanies' => $verifiedCompanies,
                'pendingCompanies' => $pendingCompanies,
                'featuredCompanies' => $featuredCompanies,
                'title' => ucfirst($filter) . ' Companies',
                'pageTitle' => 'Companies Management - ' . ucfirst($filter)
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CompaniesController::actionIndex: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load companies: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/companies/list', [
                'companies' => [],
                'filter' => $filter,
                'allCompanies' => 0,
                'verifiedCompanies' => 0,
                'pendingCompanies' => 0,
                'featuredCompanies' => 0,
                'title' => ucfirst($filter) . ' Companies',
                'pageTitle' => 'Companies Management - ' . ucfirst($filter)
            ]);
        }
    }

    /**
     * Create new company
     */
    public function actionCreate()
    {
        try {
            $db = Yii::$app->db;
            
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post();
                
                // Validate required fields
                $requiredFields = ['name', 'email'];
                foreach ($requiredFields as $field) {
                    if (empty($postData[$field])) {
                        throw new \Exception("Field '$field' is required");
                    }
                }
                
                // Generate slug
                $slug = $this->generateSlug($postData['name']);
                
                // Prepare company data
                $companyData = [
                    'name' => $postData['name'],
                    'slug' => $slug,
                    'description' => $postData['description'] ?? '',
                    'website' => $postData['website'] ?? '',
                    'email' => $postData['email'],
                    'phone' => $postData['phone'] ?? '',
                    'address' => $postData['address'] ?? '',
                    'city' => $postData['city'] ?? '',
                    'country' => $postData['country'] ?? '',
                    'size_range' => $postData['size_range'] ?? '',
                    'industry' => $postData['industry'] ?? '',
                    'founded_year' => !empty($postData['founded_year']) ? $postData['founded_year'] : null,
                    'status' => $postData['status'] ?? 'pending',
                    'verified' => isset($postData['verified']) ? 1 : 0,
                    'featured' => isset($postData['featured']) ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                // Insert company
                $db->createCommand()->insert('companies', $companyData)->execute();
                $companyId = $db->getLastInsertID();
                
                Yii::$app->session->setFlash('success', 'Company "' . $companyData['name'] . '" created successfully!');
                return $this->redirect(['view', 'id' => $companyId]);
            }
            
            return $this->render('//JobPortal/System/Admin/companies/create', [
                'title' => 'Create New Company',
                'pageTitle' => 'Create Company'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CompaniesController::actionCreate: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to create company: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/companies/create', [
                'title' => 'Create New Company',
                'pageTitle' => 'Create Company'
            ]);
        }
    }

    /**
     * View company details
     */
    public function actionView($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company with job statistics
            $company = $db->createCommand("
                SELECT c.*,
                       (SELECT COUNT(*) FROM jobs WHERE company_id = c.id) as total_jobs,
                       (SELECT COUNT(*) FROM jobs WHERE company_id = c.id AND status = 'published') as active_jobs,
                       (SELECT COUNT(*) FROM jobs WHERE company_id = c.id AND status = 'pending') as pending_jobs
                FROM companies c
                WHERE c.id = :id
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
            
            // Get recent jobs from this company
            $recentJobs = $db->createCommand("
                SELECT id, title, status, created_at, views_count, applications_count 
                FROM jobs 
                WHERE company_id = :company_id 
                ORDER BY created_at DESC 
                LIMIT 10
            ")->bindValue(':company_id', $id)->queryAll();
            
            return $this->render('//JobPortal/System/Admin/companies/view', [
                'company' => $company,
                'recentJobs' => $recentJobs,
                'title' => 'Company Details',
                'pageTitle' => 'Company: ' . $company['name']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in CompaniesController::actionView: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load company: ' . $e->getMessage());
            return $this->redirect(['all']);
        }
    }

    /**
     * Edit company
     */
    public function actionEdit($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            if (Yii::$app->request->isPost) {
                $postData = Yii::$app->request->post();
            
                // Validate required fields
                $requiredFields = ['name', 'email'];
                foreach ($requiredFields as $field) {
                    if (empty($postData[$field])) {
                        throw new \Exception("Field '$field' is required");
                    }
                }
            
                // Check if slug needs to be updated
                $slug = $company['slug'];
                if ($postData['name'] !== $company['name']) {
                    $slug = $this->generateSlug($postData['name'], $id);
                }
            
                // Prepare company data
                $companyData = [
                    'name' => $postData['name'],
                    'slug' => $slug,
                    'description' => $postData['description'] ?? '',
                    'website' => $postData['website'] ?? '',
                    'email' => $postData['email'],
                    'phone' => $postData['phone'] ?? '',
                    'address' => $postData['address'] ?? '',
                    'city' => $postData['city'] ?? '',
                    'country' => $postData['country'] ?? '',
                    'size_range' => $postData['size_range'] ?? '',
                    'industry' => $postData['industry'] ?? '',
                    'founded_year' => !empty($postData['founded_year']) ? $postData['founded_year'] : null,
                    'logo' => $postData['logo'] ?? '',
                    'status' => $postData['status'] ?? 'pending',
                    'verified' => isset($postData['verified']) ? 1 : 0,
                    'featured' => isset($postData['featured']) ? 1 : 0,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            
                // Update company
                $db->createCommand()->update('companies', $companyData, ['id' => $id])->execute();
            
                Yii::$app->session->setFlash('success', 'Company "' . $companyData['name'] . '" updated successfully!');
                return $this->redirect(['view', 'id' => $id]);
            }
        
            return $this->render('//JobPortal/System/Admin/companies/edit', [
                'company' => $company,
                'title' => 'Edit Company',
                'pageTitle' => 'Edit Company: ' . $company['name']
            ]);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionEdit: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update company: ' . $e->getMessage());
        
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Delete company
     */
    public function actionDelete($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data first
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            // Check if company has jobs
            $jobCount = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE company_id = :id")
                      ->bindValue(':id', $id)
                      ->queryScalar();
        
            if ($jobCount > 0) {
                Yii::$app->session->setFlash('error', 'Cannot delete company "' . $company['name'] . '" because it has ' . $jobCount . ' job(s) associated with it. Please delete all jobs first.');
                return $this->redirect(['view', 'id' => $id]);
            }
        
            // Delete the company
            $db->createCommand()->delete('companies', ['id' => $id])->execute();
        
            Yii::$app->session->setFlash('success', 'Company "' . $company['name'] . '" has been deleted successfully!');
            return $this->redirect(['all']);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionDelete: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to delete company: ' . $e->getMessage());
        
            return $this->redirect(['all']);
        }
    }

    /**
     * Verify company
     */
    public function actionVerify($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data first
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            // Update verification status
            $db->createCommand()->update('companies', 
                [
                    'verified' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ], 
                ['id' => $id]
            )->execute();
        
            Yii::$app->session->setFlash('success', 'Company "' . $company['name'] . '" has been verified successfully!');
            return $this->redirect(['view', 'id' => $id]);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionVerify: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to verify company: ' . $e->getMessage());
        
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Feature company
     */
    public function actionFeature($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data first
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            // Toggle featured status
            $newFeaturedStatus = $company['featured'] ? 0 : 1;
            $action = $newFeaturedStatus ? 'featured' : 'unfeatured';
        
            $db->createCommand()->update('companies', 
                [
                    'featured' => $newFeaturedStatus,
                    'updated_at' => date('Y-m-d H:i:s')
                ], 
                ['id' => $id]
            )->execute();
        
            Yii::$app->session->setFlash('success', 'Company "' . $company['name'] . '" has been ' . $action . ' successfully!');
            return $this->redirect(['view', 'id' => $id]);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionFeature: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update company feature status: ' . $e->getMessage());
        
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Approve company (change status to active)
     */
    public function actionApprove($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data first
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            // Update status to active
            $db->createCommand()->update('companies', 
                [
                    'status' => 'active',
                    'updated_at' => date('Y-m-d H:i:s')
                ], 
                ['id' => $id]
            )->execute();
        
            Yii::$app->session->setFlash('success', 'Company "' . $company['name'] . '" has been approved and is now active!');
            return $this->redirect(['view', 'id' => $id]);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionApprove: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to approve company: ' . $e->getMessage());
        
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Toggle company status
     */
    public function actionToggleStatus($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get company data first
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                throw new NotFoundHttpException('Company not found');
            }
        
            // Toggle between active and inactive
            $newStatus = ($company['status'] === 'active') ? 'inactive' : 'active';
        
            $db->createCommand()->update('companies', 
                [
                    'status' => $newStatus,
                    'updated_at' => date('Y-m-d H:i:s')
                ], 
                ['id' => $id]
            )->execute();
        
            Yii::$app->session->setFlash('success', 'Company "' . $company['name'] . '" status changed to ' . $newStatus . '!');
            return $this->redirect(['view', 'id' => $id]);
        
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
        
            Yii::error("Error in CompaniesController::actionToggleStatus: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to toggle company status: ' . $e->getMessage());
        
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Generate unique slug from name
     */
    private function generateSlug($name, $excludeId = null)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $originalSlug = $slug;
        $counter = 1;
        
        $db = Yii::$app->db;
        $query = "SELECT id FROM companies WHERE slug = :slug";
        $params = [':slug' => $slug];
        
        if ($excludeId) {
            $query .= " AND id != :excludeId";
            $params[':excludeId'] = $excludeId;
        }
        
        while ($db->createCommand($query)->bindValues($params)->queryScalar()) {
            $slug = $originalSlug . '-' . $counter;
            $params[':slug'] = $slug;
            $counter++;
        }
        
        return $slug;
    }

    /**
     * Create companies table if it doesn't exist
     */
    private function createCompaniesTable()
    {
        $db = Yii::$app->db;
        
        $sql = "CREATE TABLE IF NOT EXISTS companies (
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
        
        $db->createCommand($sql)->execute();
        
        // Insert sample companies if table is empty
        $count = $db->createCommand("SELECT COUNT(*) FROM companies")->queryScalar();
        if ($count == 0) {
            $this->insertSampleCompanies();
        }
    }

    /**
     * Insert sample companies
     */
    private function insertSampleCompanies()
    {
        $db = Yii::$app->db;
        
        $companies = [
            ['TechCorp Ltd', 'techcorp-ltd', 'Leading technology company', 'active', 1, 0],
            ['StartupVenture Inc', 'startupventure-inc', 'Innovative startup company', 'active', 1, 1],
            ['Global Solutions', 'global-solutions', 'International consulting firm', 'pending', 0, 0],
            ['Digital Agency Pro', 'digital-agency-pro', 'Full-service digital agency', 'active', 1, 1],
            ['Enterprise Corp', 'enterprise-corp', 'Large enterprise corporation', 'active', 1, 0],
        ];
        
        foreach ($companies as $company) {
            $db->createCommand()->insert('companies', [
                'name' => $company[0],
                'slug' => $company[1],
                'description' => $company[2],
                'status' => $company[3],
                'verified' => $company[4],
                'featured' => $company[5],
                'email' => strtolower(str_replace(' ', '', $company[0])) . '@example.com',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ])->execute();
        }
    }

    /**
     * Check if company can be deleted (AJAX endpoint)
     */
    public function actionCheckDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        try {
            $db = Yii::$app->db;
            
            // Get company data
            $company = $db->createCommand("SELECT * FROM companies WHERE id = :id")
                     ->bindValue(':id', $id)
                     ->queryOne();
        
            if (!$company) {
                return [
                    'success' => false,
                    'message' => 'Company not found',
                    'canDelete' => false
                ];
            }
        
            // Check job count
            $jobCount = $db->createCommand("SELECT COUNT(*) FROM jobs WHERE company_id = :id")
                      ->bindValue(':id', $id)
                      ->queryScalar();
        
            // You can also check for applications if needed
            $applicationCount = 0; // Add query if you have applications table
        
            $canDelete = ($jobCount == 0 && $applicationCount == 0);
        
            return [
                'success' => true,
                'canDelete' => $canDelete,
                'jobCount' => (int)$jobCount,
                'applicationCount' => (int)$applicationCount,
                'companyName' => $company['name']
            ];
        
        } catch (\Exception $e) {
            Yii::error("Error in CompaniesController::actionCheckDelete: " . $e->getMessage());
        
            return [
                'success' => false,
                'message' => 'Error checking delete permission',
                'canDelete' => false
            ];
        }
    }
}