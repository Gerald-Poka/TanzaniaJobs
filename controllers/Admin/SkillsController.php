<?php

namespace app\controllers\admin;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SkillsController extends Controller
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
     * Display list of all skills
     */
    public function actionList() 
    {
        try {
            $db = Yii::$app->db;
            
            // Check if skills table exists
            try {
                $db->createCommand("SELECT 1 FROM skills LIMIT 1")->queryScalar();
            } catch (\Exception $e) {
                // Create skills table if it doesn't exist
                $this->createSkillsTable();
            }
            
            // Query to get all skills with category info
            $query = "SELECT 
                        s.id, 
                        s.name,
                        s.slug,
                        s.description,
                        s.status,
                        s.sort_order,
                        s.category_id,
                        s.created_at,
                        s.updated_at,
                        c.name as category_name
                      FROM skills s
                      LEFT JOIN job_categories c ON s.category_id = c.id
                      ORDER BY s.sort_order ASC, s.created_at DESC";
            
            $skills = $db->createCommand($query)->queryAll();
            
            // Process the data
            foreach ($skills as &$skill) {
                if (empty($skill['status'])) {
                    $skill['status'] = 'active';
                }
            }
            
            // Statistics
            $totalSkills = count($skills);
            $activeSkills = count(array_filter($skills, function($skill) { 
                return $skill['status'] === 'active'; 
            }));
            $inactiveSkills = $totalSkills - $activeSkills;
            
            return $this->render('//JobPortal/System/Admin/skills/list', [
                'skills' => $skills,
                'totalSkills' => $totalSkills,
                'activeSkills' => $activeSkills,
                'inactiveSkills' => $inactiveSkills,
                'title' => 'Skills List',
                'pageTitle' => 'Skills Management'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in SkillsController::actionList: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load skills: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/skills/list', [
                'skills' => [],
                'totalSkills' => 0,
                'activeSkills' => 0,
                'inactiveSkills' => 0,
                'title' => 'Skills List',
                'pageTitle' => 'Skills Management'
            ]);
        }
    }

    /**
     * Create new skill
     */
    public function actionCreate()
    {
        try {
            $db = Yii::$app->db;
            
            // Get categories for dropdown
            $categories = $db->createCommand("SELECT id, name FROM job_categories WHERE status = 'active' ORDER BY name ASC")->queryAll();
            
            if (Yii::$app->request->isPost) {
                $name = trim(Yii::$app->request->post('name'));
                $description = trim(Yii::$app->request->post('description'));
                $categoryId = Yii::$app->request->post('category_id') ?: null;
                $status = Yii::$app->request->post('status', 'active');
                
                if (empty($name)) {
                    throw new \Exception('Skill name is required');
                }
                
                // Generate slug
                $slug = $this->generateSlug($name);
                
                // Check if slug exists
                $existingSkill = $db->createCommand("SELECT id FROM skills WHERE slug = :slug")->bindValue(':slug', $slug)->queryScalar();
                if ($existingSkill) {
                    $slug = $slug . '-' . time();
                }
                
                // Get next sort order
                $maxSortOrder = $db->createCommand("SELECT MAX(sort_order) FROM skills")->queryScalar();
                $sortOrder = ($maxSortOrder ?? 0) + 1;
                
                // Insert skill
                $db->createCommand()->insert('skills', [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'category_id' => $categoryId,
                    'status' => $status,
                    'sort_order' => $sortOrder,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ])->execute();
                
                Yii::$app->session->setFlash('success', 'Skill created successfully!');
                return $this->redirect(['list']);
            }
            
            // Get category_id from URL if provided
            $preSelectedCategoryId = Yii::$app->request->get('category_id');
            
            return $this->render('//JobPortal/System/Admin/skills/create', [
                'categories' => $categories,
                'preSelectedCategoryId' => $preSelectedCategoryId,
                'title' => 'Create Skill',
                'pageTitle' => 'Create New Skill'
            ]);
            
        } catch (\Exception $e) {
            Yii::error("Error in SkillsController::actionCreate: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to create skill: ' . $e->getMessage());
            
            return $this->render('//JobPortal/System/Admin/skills/create', [
                'categories' => $categories ?? [],
                'preSelectedCategoryId' => null,
                'title' => 'Create Skill',
                'pageTitle' => 'Create New Skill'
            ]);
        }
    }

    /**
     * View skill details
     */
    public function actionView($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get skill with category info
            $skill = $db->createCommand("
                SELECT s.*, c.name as category_name 
                FROM skills s 
                LEFT JOIN job_categories c ON s.category_id = c.id 
                WHERE s.id = :id
            ")->bindValue(':id', $id)->queryOne();
            
            if (!$skill) {
                throw new NotFoundHttpException('Skill not found');
            }
            
            return $this->render('//JobPortal/System/Admin/skills/view', [
                'skill' => $skill,
                'title' => 'Skill Details',
                'pageTitle' => 'Skill: ' . $skill['name']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in SkillsController::actionView: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to load skill: ' . $e->getMessage());
            return $this->redirect(['list']);
        }
    }

    /**
     * Edit skill
     */
    public function actionEdit($id)
    {
        try {
            $db = Yii::$app->db;
            
            // Get skill
            $skill = $db->createCommand("SELECT * FROM skills WHERE id = :id")->bindValue(':id', $id)->queryOne();
            if (!$skill) {
                throw new NotFoundHttpException('Skill not found');
            }
            
            // Get categories for dropdown
            $categories = $db->createCommand("SELECT id, name FROM job_categories WHERE status = 'active' ORDER BY name ASC")->queryAll();
            
            if (Yii::$app->request->isPost) {
                $name = trim(Yii::$app->request->post('name'));
                $description = trim(Yii::$app->request->post('description'));
                $categoryId = Yii::$app->request->post('category_id') ?: null;
                $status = Yii::$app->request->post('status', 'active');
                
                if (empty($name)) {
                    throw new \Exception('Skill name is required');
                }
                
                // Generate slug if name changed
                $slug = $skill['slug'];
                if ($name !== $skill['name']) {
                    $newSlug = $this->generateSlug($name);
                    
                    // Check if new slug exists (excluding current skill)
                    $existingSkill = $db->createCommand("SELECT id FROM skills WHERE slug = :slug AND id != :id")
                        ->bindValue(':slug', $newSlug)
                        ->bindValue(':id', $id)
                        ->queryScalar();
                    
                    if (!$existingSkill) {
                        $slug = $newSlug;
                    }
                }
                
                // Update skill
                $db->createCommand()->update('skills', [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => $description,
                    'category_id' => $categoryId,
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Skill updated successfully!');
                return $this->redirect(['view', 'id' => $id]);
            }
            
            return $this->render('//JobPortal/System/Admin/skills/edit', [
                'skill' => $skill,
                'categories' => $categories,
                'title' => 'Edit Skill',
                'pageTitle' => 'Edit: ' . $skill['name']
            ]);
            
        } catch (\Exception $e) {
            if ($e instanceof NotFoundHttpException) {
                throw $e;
            }
            
            Yii::error("Error in SkillsController::actionEdit: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to edit skill: ' . $e->getMessage());
            return $this->redirect(['list']);
        }
    }

    /**
     * Delete skill
     */
    public function actionDelete($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                
                // Check if skill exists
                $skill = $db->createCommand("SELECT name FROM skills WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$skill) {
                    throw new NotFoundHttpException('Skill not found');
                }
                
                // Delete the skill
                $db->createCommand()->delete('skills', ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Skill "' . $skill['name'] . '" deleted successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in SkillsController::actionDelete: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to delete skill: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }

    /**
     * Toggle skill status
     */
    public function actionToggleStatus($id)
    {
        try {
            if (Yii::$app->request->isPost) {
                $db = Yii::$app->db;
                $status = Yii::$app->request->post('status');
                
                if (!in_array($status, ['active', 'inactive'])) {
                    throw new \Exception('Invalid status');
                }
                
                // Check if skill exists
                $skill = $db->createCommand("SELECT name FROM skills WHERE id = :id")->bindValue(':id', $id)->queryOne();
                if (!$skill) {
                    throw new NotFoundHttpException('Skill not found');
                }
                
                // Update status
                $db->createCommand()->update('skills', [
                    'status' => $status,
                    'updated_at' => date('Y-m-d H:i:s')
                ], ['id' => $id])->execute();
                
                Yii::$app->session->setFlash('success', 'Skill "' . $skill['name'] . '" ' . $status . ' successfully!');
            }
        } catch (\Exception $e) {
            Yii::error("Error in SkillsController::actionToggleStatus: " . $e->getMessage());
            Yii::$app->session->setFlash('error', 'Failed to update skill status: ' . $e->getMessage());
        }
        
        return $this->redirect(['list']);
    }

    /**
     * Create skills table if it doesn't exist
     */
    private function createSkillsTable()
    {
        $db = Yii::$app->db;
        
        $sql = "CREATE TABLE IF NOT EXISTS skills (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            description TEXT,
            category_id INT NULL,
            status ENUM('active', 'inactive') DEFAULT 'active',
            sort_order INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_category_id (category_id),
            INDEX idx_status (status),
            INDEX idx_sort_order (sort_order),
            FOREIGN KEY (category_id) REFERENCES job_categories(id) ON DELETE SET NULL
        )";
        
        $db->createCommand($sql)->execute();
    }

    /**
     * Generate URL-friendly slug from string
     */
    private function generateSlug($string)
    {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }
}