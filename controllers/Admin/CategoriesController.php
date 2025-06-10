<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\StringHelper;

class CategoriesController extends Controller
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
                ],
            ],
        ];
    }

    /**
     * Display list of all categories
     */
    public function actionList() 
    {
        try {
            // Get database connection
            $db = Yii::$app->db;
            
            // Check if tables exist
            $skillsTableExists = false;
            $jobsTableExists = false;
            
            try {
                $db->createCommand("SELECT 1 FROM skills LIMIT 1")->queryScalar();
                $skillsTableExists = true;
            } catch (\Exception $e) {
                Yii::info("Skills table not found, skipping skills count");
            }
            
            try {
                $db->createCommand("SELECT 1 FROM jobs LIMIT 1")->queryScalar();
                $jobsTableExists = true;
            } catch (\Exception $e) {
                Yii::info("Jobs table not found, skipping jobs count");
            }
            
            // Build query based on table availability
            $skillsSubquery = $skillsTableExists ? 
                "(SELECT COUNT(*) FROM skills s WHERE s.category_id = c.id)" : "0";
            $jobsSubquery = $jobsTableExists ? 
                "(SELECT COUNT(*) FROM jobs j WHERE j.category_id = c.id)" : "0";
            
            $query = "SELECT 
                        c.id, 
                        c.name,
                        c.slug,
                        c.description,
                        c.icon,
                        c.parent_id,
                        c.status,
                        c.sort_order,
                        c.created_at,
                        c.updated_at,
                        {$skillsSubquery} as skills_count,
                        {$jobsSubquery} as jobs_count,
                        parent.name as parent_name
                      FROM job_categories c
                      LEFT JOIN job_categories parent ON c.parent_id = parent.id
                      ORDER BY c.sort_order ASC, c.created_at DESC";
            
            // Execute query
            $categories = $db->createCommand($query)->queryAll();
            
            // Process the data for the view
            foreach ($categories as &$category) {
                // Ensure counts are integers
                $category['jobs_count'] = (int)($category['jobs_count'] ?? 0);
                $category['skills_count'] = (int)($category['skills_count'] ?? 0);
                
                // Set default icon if none exists
                if (empty($category['icon'])) {
                    $category['icon'] = 'ri-folder-line';
                }
                
                // Ensure status is set
                if (empty($category['status'])) {
                    $category['status'] = 'active';
                }
            }
            
            // Add statistics for the view
            $totalCategories = count($categories);
            $activeCategories = count(array_filter($categories, function($cat) { 
                return $cat['status'] === 'active'; 
            }));
            $inactiveCategories = $totalCategories - $activeCategories;
            
            // Render the view
            return $this->render('//JobPortal/System/Admin/categories/list', [
                'categories' => $categories,
                'totalCategories' => $totalCategories,
                'activeCategories' => $activeCategories,
                'inactiveCategories' => $inactiveCategories,
                'title' => 'Category List',
                'pageTitle' => 'Job Categories'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionList: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load categories: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/categories/list', [
                'categories' => [],
                'totalCategories' => 0,
                'activeCategories' => 0,
                'inactiveCategories' => 0,
                'title' => 'Category List',
                'pageTitle' => 'Job Categories'
            ]);
        }
    }

    /**
     * Display form to create new category
     */
    public function actionCreate()
    {
        try {
            $db = Yii::$app->db;
            
            // Get parent categories for dropdown
            $parentCategories = $db->createCommand("
                SELECT id, name FROM job_categories 
                WHERE parent_id IS NULL AND status = 'active' 
                ORDER BY sort_order ASC, name ASC
            ")->queryAll();
            
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                
                // Validate required fields
                if (empty($data['name'])) {
                    throw new \Exception('Category name is required');
                }
                
                // Generate slug from name
                $slug = $this->generateSlug($data['name']);
                
                // Check if slug already exists
                $existingCategory = $db->createCommand("SELECT id FROM job_categories WHERE slug = :slug")
                    ->bindValue(':slug', $slug)
                    ->queryScalar();
                
                if ($existingCategory) {
                    $slug = $slug . '-' . time();
                }
                
                // Get next sort order
                $nextSortOrder = $db->createCommand("SELECT COALESCE(MAX(sort_order), 0) + 1 FROM job_categories")->queryScalar();
                
                // Insert new category
                $db->createCommand()->insert('job_categories', [
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'] ?? null,
                    'icon' => $data['icon'] ?? 'ri-folder-line',
                    'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
                    'status' => $data['status'] ?? 'active',
                    'sort_order' => $nextSortOrder,
                    'meta_title' => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                ])->execute();
                
                Yii::$app->session->setFlash('success', 'Category "' . $data['name'] . '" created successfully!');
                return $this->redirect(['list']);
            }
            
            return $this->render('//JobPortal/System/Admin/categories/create', [
                'parentCategories' => $parentCategories,
                'title' => 'Create Category',
                'pageTitle' => 'Create New Category'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionCreate: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to create category: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/categories/create', [
                'parentCategories' => $parentCategories ?? [],
                'title' => 'Create Category',
                'pageTitle' => 'Create New Category'
            ]);
        }
    }

    /**
     * Generate URL-friendly slug from string
     */
    private function generateSlug($string)
    {
        // Convert to lowercase
        $slug = strtolower($string);
        
        // Replace spaces and special characters with hyphens
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        
        // Remove leading/trailing hyphens
        $slug = trim($slug, '-');
        
        return $slug;
    }

    /**
     * View category details
     */
    public function actionView($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get category with parent info
            $category = $db->createCommand("
                SELECT c.*, parent.name as parent_name 
                FROM job_categories c 
                LEFT JOIN job_categories parent ON c.parent_id = parent.id 
                WHERE c.id = :id
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$category) {
                throw new NotFoundHttpException('Category not found');
            }
            
            // Get subcategories
            $subcategories = $db->createCommand("
                SELECT * FROM job_categories 
                WHERE parent_id = :id 
                ORDER BY sort_order ASC, name ASC
            ")->bindValue(':id', $id)->queryAll();
            
            // Get skills in this category
            $skills = $db->createCommand("
                SELECT * FROM skills 
                WHERE category_id = :id 
                ORDER BY sort_order ASC, name ASC
            ")->bindValue(':id', $id)->queryAll();
            
            // Get jobs count (check if jobs table exists first)
            $jobsCount = 0;
            try {
                $jobsCount = $db->createCommand("
                    SELECT COUNT(*) FROM jobs 
                    WHERE category_id = :id
                ")->bindValue(':id', $id)->queryScalar();
            } catch (\Exception $e) {
                // Jobs table doesn't exist yet, set count to 0
                Yii::info("Jobs table not found in actionView, setting jobs count to 0");
            }
            
            return $this->render('//JobPortal/System/Admin/categories/view', [
                'category' => $category,
                'subcategories' => $subcategories,
                'skills' => $skills,
                'jobsCount' => $jobsCount,
                'title' => 'View Category',
                'pageTitle' => 'Category: ' . $category['name']
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionView: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load category: ' . $e->getMessage());
            return $this->redirect(['list']);
        }
    }

    /**
     * Display form to edit existing category
     */
    public function actionEdit($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get category data
            $category = $db->createCommand("SELECT * FROM job_categories WHERE id = :id")
                ->bindValue(':id', $id)
                ->queryOne();
            
            if (!$category) {
                throw new NotFoundHttpException('Category not found');
            }
            
            // Get parent categories for dropdown (excluding current category and its children)
            $parentCategories = $db->createCommand("
                SELECT id, name FROM job_categories 
                WHERE id != :id AND parent_id IS NULL AND status = 'active' 
                ORDER BY sort_order ASC, name ASC
            ")->bindValue(':id', $id)->queryAll();
            
            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                
                // Validate required fields
                if (empty($data['name'])) {
                    throw new \Exception('Category name is required');
                }
                
                // Generate slug from name if it changed
                $slug = $category['slug'];
                if ($data['name'] !== $category['name']) {
                    $newSlug = $this->generateSlug($data['name']);
                    
                    // Check if new slug already exists
                    $existingCategory = $db->createCommand("SELECT id FROM job_categories WHERE slug = :slug AND id != :id")
                        ->bindValue(':slug', $newSlug)
                        ->bindValue(':id', $id)
                        ->queryScalar();
                    
                    if (!$existingCategory) {
                        $slug = $newSlug;
                    }
                }
                
                // Update category
                $db->createCommand()->update('job_categories', [
                    'name' => $data['name'],
                    'slug' => $slug,
                    'description' => $data['description'] ?? null,
                    'icon' => $data['icon'] ?? 'ri-folder-line',
                    'parent_id' => !empty($data['parent_id']) ? $data['parent_id'] : null,
                    'status' => $data['status'] ?? 'active',
                    'meta_title' => $data['meta_title'] ?? null,
                    'meta_description' => $data['meta_description'] ?? null,
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Category "' . $data['name'] . '" updated successfully!');
                return $this->redirect(['list']);
            }
            
            return $this->render('//JobPortal/System/Admin/categories/edit', [
                'category' => $category,
                'parentCategories' => $parentCategories,
                'title' => 'Edit Category',
                'pageTitle' => 'Edit Category: ' . $category['name']
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionEdit: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to edit category: ' . $e->getMessage());
            return $this->redirect(['list']);
        }
    }

    /**
     * Toggle category status (active/inactive)
     */
    public function actionToggleStatus($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get current status
            $currentStatus = $db->createCommand("SELECT status, name FROM job_categories WHERE id = :id")
                ->bindValue(':id', $id)
                ->queryOne();
            
            if (!$currentStatus) {
                throw new NotFoundHttpException('Category not found');
            }
            
            $newStatus = Yii::$app->request->post('status');
            
            if (!in_array($newStatus, ['active', 'inactive'])) {
                throw new \Exception('Invalid status value');
            }
            
            // Update status
            $db->createCommand()->update('job_categories', [
                'status' => $newStatus
            ], ['id' => $id])->execute();
            
            $action = $newStatus === 'active' ? 'activated' : 'deactivated';
            Yii::$app->session->setFlash('success', "Category \"{$currentStatus['name']}\" has been {$action} successfully!");
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionToggleStatus: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update category status: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }

    /**
     * Delete category
     */
    public function actionDelete($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get category info
            $category = $db->createCommand("SELECT name FROM job_categories WHERE id = :id")
                ->bindValue(':id', $id)
                ->queryOne();
            
            if (!$category) {
                throw new NotFoundHttpException('Category not found');
            }
            
            // Start transaction
            $transaction = $db->beginTransaction();
            
            try {
                // Update subcategories to remove parent reference
                $db->createCommand()->update('job_categories', [
                    'parent_id' => null
                ], ['parent_id' => $id])->execute();
                
                // Update skills to remove category reference
                $db->createCommand()->update('skills', [
                    'category_id' => null
                ], ['category_id' => $id])->execute();
                
                // Update jobs to remove category reference (if jobs table exists)
                try {
                    $db->createCommand()->update('jobs', [
                        'category_id' => null
                    ], ['category_id' => $id])->execute();
                } catch (\Exception $e) {
                    // Jobs table might not exist yet, ignore this error
                    Yii::warning("Jobs table not found during category deletion: " . $e->getMessage());
                }
                
                // Delete the category
                $db->createCommand()->delete('job_categories', ['id' => $id])->execute();
                
                $transaction->commit();
                
                Yii::$app->session->setFlash('success', "Category \"{$category['name']}\" has been deleted successfully!");
                
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionDelete: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to delete category: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }

    /**
     * Update sort order for categories
     */
    public function actionUpdateOrder()
    {
        try {
            if (Yii::$app->request->isPost) {
                $categoryIds = Yii::$app->request->post('categoryIds', []);
                $db = Yii::$app->db;
                
                $transaction = $db->beginTransaction();
                
                try {
                    foreach ($categoryIds as $index => $categoryId) {
                        $db->createCommand()->update('job_categories', [
                            'sort_order' => $index + 1
                        ], ['id' => $categoryId])->execute();
                    }
                    
                    $transaction->commit();
                    
                    return $this->asJson(['success' => true, 'message' => 'Order updated successfully']);
                    
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionUpdateOrder: " . $e->getMessage());
            return $this->asJson(['success' => false, 'message' => 'Failed to update order']);
        }
        
        return $this->asJson(['success' => false, 'message' => 'Invalid request']);
    }

    /**
     * Bulk status update for multiple categories
     */
    public function actionBulkStatusUpdate()
    {
        try {
            if (Yii::$app->request->isPost) {
                $ids = Yii::$app->request->post('ids', []);
                $status = Yii::$app->request->post('status');
                
                if (empty($ids) || !in_array($status, ['active', 'inactive'])) {
                    throw new \Exception('Invalid data provided');
                }
                
                $db = Yii::$app->db;
                $transaction = $db->beginTransaction();
                
                try {
                    foreach ($ids as $id) {
                        $db->createCommand()->update('job_categories', [
                            'status' => $status
                        ], ['id' => $id])->execute();
                    }
                    
                    $transaction->commit();
                    
                    $action = $status === 'active' ? 'activated' : 'deactivated';
                    $count = count($ids);
                    Yii::$app->session->setFlash('success', "{$count} categories have been {$action} successfully!");
                    
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionBulkStatusUpdate: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update categories: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }

    /**
     * Bulk delete multiple categories
     */
    public function actionBulkDelete()
    {
        try {
            if (Yii::$app->request->isPost) {
                $ids = Yii::$app->request->post('ids', []);
                
                if (empty($ids)) {
                    throw new \Exception('No categories selected');
                }
                
                $db = Yii::$app->db;
                $transaction = $db->beginTransaction();
                
                try {
                    foreach ($ids as $id) {
                        // Update subcategories to remove parent reference
                        $db->createCommand()->update('job_categories', [
                            'parent_id' => null
                        ], ['parent_id' => $id])->execute();
                        
                        // Update skills to remove category reference if table exists
                        try {
                            $db->createCommand()->update('skills', [
                                'category_id' => null
                            ], ['category_id' => $id])->execute();
                        } catch (\Exception $e) {
                            // Skills table might not exist
                        }
                        
                        // Update jobs to remove category reference if table exists
                        try {
                            $db->createCommand()->update('jobs', [
                                'category_id' => null
                            ], ['category_id' => $id])->execute();
                        } catch (\Exception $e) {
                            // Jobs table might not exist
                        }
                        
                        // Delete the category
                        $db->createCommand()->delete('job_categories', ['id' => $id])->execute();
                    }
                    
                    $transaction->commit();
                    
                    $count = count($ids);
                    Yii::$app->session->setFlash('success', "{$count} categories have been deleted successfully!");
                    
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } catch (\Exception $e) {
            Yii::error("Error in CategoriesController::actionBulkDelete: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to delete categories: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }
}