<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;
use app\models\User;

class AiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['career-recommendations', 'job-matching', 'skills-assessment', 'get-assessment-questions'],
                'rules' => [
                    [
                        'actions' => ['career-recommendations', 'job-matching', 'skills-assessment', 'get-assessment-questions'],
                        'allow' => true,
                        'roles' => ['@'], // Only authenticated users
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'career-recommendations' => ['GET'],
                    'job-matching' => ['GET', 'POST'],
                    'skills-assessment' => ['GET', 'POST'],
                    'get-assessment-questions' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Career Recommendations Action
     * Provides AI-powered career guidance based on user profile and database categories
     */
    public function actionCareerRecommendations()
    {
        $user = Yii::$app->user->identity;
        
        // Get user profile data
        $userProfile = $this->getUserProfile($user);
        
        // Get career categories from database
        $careerCategories = $this->getCareerCategoriesFromDatabase();
        
        // Calculate match scores for each category
        foreach ($careerCategories as &$category) {
            $category['match_score'] = $this->calculateMatchScore($userProfile, $category);
            $category['personalized_tips'] = $this->getPersonalizedTips($userProfile, $category);
        }
        
        // Sort by match score (highest first)
        usort($careerCategories, function($a, $b) {
            return $b['match_score'] - $a['match_score'];
        });
        
        // Use the correct view path where your file is located
        return $this->render('/JobPortal/System/User/ai/career-recommendations', [
            'careerCategories' => $careerCategories,
            'userProfile' => $userProfile,
            'userName' => $userProfile['name'], // Add this for the view
        ]);
    }

    /**
     * Get career categories from database with enhanced data
     */
    private function getCareerCategoriesFromDatabase()
    {
        try {
            $db = Yii::$app->db;
            
            // Check if required tables exist (same approach as CategoriesController)
            $tablesExist = $this->checkRequiredTables();
            
            // Build the skills count part of the query
            $skillsSubquery = $tablesExist['skills'] 
                ? "(SELECT COUNT(*) FROM skills s WHERE s.category_id = c.id AND s.status = 'active')" 
                : "0";
                
            // Build the jobs count part of the query  
            $jobsSubquery = $tablesExist['jobs']
                ? "(SELECT COUNT(*) FROM jobs j WHERE j.category_id = c.id AND j.status = 'published')" 
                : "0";
                
            // Get categories from database (same query structure as CategoriesController)
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
                      WHERE c.status = 'active'
                      ORDER BY c.sort_order ASC, c.name ASC";
            
            $categories = $db->createCommand($query)->queryAll();
            
            // Process each category and add AI-specific data
            $processedCategories = [];
            foreach ($categories as $category) {
                // Ensure counts are integers (same as CategoriesController)
                $category['jobs_count'] = (int)($category['jobs_count'] ?? 0);
                $category['skills_count'] = (int)($category['skills_count'] ?? 0);
                
                // Set default icon if none exists
                if (empty($category['icon'])) {
                    $category['icon'] = 'ri-folder-line';
                }
                
                $processedCategory = $this->enhanceCategoryWithAIData($category, $tablesExist);
                if ($processedCategory) {
                    $processedCategories[] = $processedCategory;
                }
            }
            
            return $processedCategories;
            
        } catch (\Exception $e) {
            Yii::error("Error fetching categories from database: " . $e->getMessage());
            Yii::error("Trace: " . $e->getTraceAsString());
            
            // Fallback to default categories if database fails
            return $this->getDefaultCareerCategories();
        }
    }

    /**
     * Check if required database tables exist (same approach as CategoriesController)
     */
    private function checkRequiredTables()
    {
        $db = Yii::$app->db;
        $exists = [
            'skills' => false,
            'jobs' => false
        ];
        
        try {
            $db->createCommand("SELECT 1 FROM skills LIMIT 1")->queryScalar();
            $exists['skills'] = true;
        } catch (\Exception $e) {
            Yii::info("Skills table not found, skipping skills count");
        }
        
        try {
            $db->createCommand("SELECT 1 FROM jobs LIMIT 1")->queryScalar();
            $exists['jobs'] = true;
        } catch (\Exception $e) {
            Yii::info("Jobs table not found, skipping jobs count");
        }
        
        return $exists;
    }

    /**
     * Enhance database category with AI-specific data
     */
    private function enhanceCategoryWithAIData($category, $tablesExist)
    {
        $db = Yii::$app->db;
        
        // Get skills for this category (with proper error handling)
        $skills = [];
        if ($tablesExist['skills']) {
            try {
                $skillsData = $db->createCommand("
                    SELECT name FROM skills 
                    WHERE category_id = :category_id AND status = 'active' 
                    ORDER BY sort_order ASC, name ASC
                ")->bindValue(':category_id', $category['id'])->queryAll();
                
                $skills = array_column($skillsData, 'name');
            } catch (\Exception $e) {
                Yii::warning("Error fetching skills for category {$category['id']}: " . $e->getMessage());
            }
        }
        
        // If no skills found, use default based on category name
        if (empty($skills)) {
            $skills = $this->getDefaultSkillsForCategory($category['name']);
        }
        
        // Map category data to AI format
        $aiCategory = [
            'id' => $category['id'],
            'name' => $category['name'],
            'slug' => $category['slug'],
            'icon' => $category['icon'] ?: $this->getDefaultIconForCategory($category['name']),
            'color' => $this->getColorForCategory($category['name']),
            'description' => $category['description'] ?: $this->getDefaultDescriptionForCategory($category['name']),
            'skills' => $skills,
            'qualifications' => $this->getQualificationsForCategory($category['name']),
            'experience' => $this->getExperienceLevelForCategory($category['name']),
            'salary_range' => $this->getSalaryRangeForCategory($category['name']),
            'growth_rate' => $this->getGrowthRateForCategory($category['name']),
            'job_count' => $category['jobs_count'], // Already converted to int above
            'skills_count' => $category['skills_count'], // Already converted to int above
            'recommendations' => $this->getRecommendationsForCategory($category['name']),
            'learning_resources' => $this->getLearningResourcesForCategory($category['name'])
        ];
        
        return $aiCategory;
    }

    /**
     * Get default skills for a category based on its name
     */
    private function getDefaultSkillsForCategory($categoryName)
    {
        $skillsMap = [
            // Your specific categories from the database
            'Information Technology' => ['Programming', 'Database Management', 'System Administration', 'Cybersecurity', 'Cloud Computing'],
            'Healthcare' => ['Patient Care', 'Medical Knowledge', 'Communication', 'Attention to Detail', 'Empathy'],
            'Finance & Banking' => ['Financial Analysis', 'Accounting', 'Risk Management', 'Regulatory Compliance', 'Excel'],
            'Education' => ['Teaching', 'Curriculum Development', 'Communication', 'Patience', 'Subject Matter Expertise'],
            'Engineering' => ['Technical Design', 'Problem Solving', 'Project Management', 'CAD Software', 'Mathematics'],
            'Marketing & Sales' => ['Communication', 'Lead Generation', 'Customer Relations', 'Digital Marketing', 'Analytics'],
            'Human Resources' => ['Recruitment', 'Employee Relations', 'Training', 'Performance Management', 'Communication'],
            'Construction' => ['Project Management', 'Safety Compliance', 'Technical Drawing', 'Quality Control', 'Team Leadership'],
            
            // Keep existing mappings as fallbacks
            'Software Development' => ['Programming Languages', 'Problem Solving', 'Database Management', 'Version Control'],
            'Digital Marketing' => ['SEO/SEM', 'Social Media Management', 'Content Creation', 'Analytics', 'Communication'],
            'Data Science' => ['Python', 'R', 'Statistics', 'Machine Learning', 'Data Visualization', 'SQL'],
            'Project Management' => ['Leadership', 'Communication', 'Risk Management', 'Agile/Scrum', 'Planning'],
            'UI/UX Design' => ['Design Tools', 'User Research', 'Prototyping', 'Visual Design', 'Figma'],
            'Cybersecurity' => ['Network Security', 'Ethical Hacking', 'Risk Assessment', 'Compliance'],
            'Web Development' => ['HTML', 'CSS', 'JavaScript', 'React', 'Node.js', 'Database'],
            'Mobile Development' => ['Android', 'iOS', 'React Native', 'Flutter', 'Mobile UI/UX'],
            'DevOps' => ['Docker', 'Kubernetes', 'CI/CD', 'Cloud Computing', 'Linux'],
            'Sales' => ['Communication', 'Negotiation', 'CRM', 'Lead Generation', 'Customer Relations'],
            'Human Resources' => ['Recruitment', 'Employee Relations', 'Training', 'Performance Management'],
            'Finance' => ['Financial Analysis', 'Accounting', 'Excel', 'Risk Management', 'Reporting'],
            'Customer Service' => ['Communication', 'Problem Solving', 'Patience', 'Product Knowledge'],
            'Content Writing' => ['Writing', 'SEO', 'Research', 'Editing', 'Content Strategy']
        ];
        
        // Try exact match first
        if (isset($skillsMap[$categoryName])) {
            return $skillsMap[$categoryName];
        }
        
        // Try partial match for variations
        foreach ($skillsMap as $key => $skills) {
            if (stripos($categoryName, $key) !== false || stripos($key, $categoryName) !== false) {
                return $skills;
            }
        }
        
        // Default skills
        return ['Communication', 'Problem Solving', 'Teamwork', 'Time Management'];
    }

    /**
     * Get default icon for category
     */
    private function getDefaultIconForCategory($categoryName)
    {
        $iconMap = [
            'Software Development' => 'ri-code-s-slash-line',
            'Digital Marketing' => 'ri-megaphone-line',
            'Data Science' => 'ri-bar-chart-line',
            'Project Management' => 'ri-task-line',
            'UI/UX Design' => 'ri-palette-line',
            'Cybersecurity' => 'ri-shield-check-line',
            'Web Development' => 'ri-global-line',
            'Mobile Development' => 'ri-smartphone-line',
            'DevOps' => 'ri-server-line',
            'Sales' => 'ri-line-chart-line',
            'Human Resources' => 'ri-team-line',
            'Finance' => 'ri-money-dollar-circle-line',
            'Customer Service' => 'ri-customer-service-line',
            'Content Writing' => 'ri-edit-line'
        ];
        
        foreach ($iconMap as $key => $icon) {
            if (stripos($categoryName, $key) !== false) {
                return $icon;
            }
        }
        
        return 'ri-briefcase-line'; // Default icon
    }

    /**
     * Get color theme for category
     */
    private function getColorForCategory($categoryName)
    {
        $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
        $index = abs(crc32($categoryName)) % count($colors);
        return $colors[$index];
    }

    /**
     * Get default description for category
     */
    private function getDefaultDescriptionForCategory($categoryName)
    {
        $descriptions = [
            'Software Development' => 'Build applications, websites, and software solutions',
            'Digital Marketing' => 'Promote brands and products through digital channels',
            'Data Science' => 'Analyze data to derive insights and make predictions',
            'Project Management' => 'Lead teams and deliver projects successfully',
            'UI/UX Design' => 'Design user-friendly interfaces and experiences',
            'Cybersecurity' => 'Protect systems and data from security threats',
            'Web Development' => 'Create and maintain websites and web applications',
            'Mobile Development' => 'Build mobile applications for smartphones and tablets',
            'DevOps' => 'Bridge development and operations for efficient software delivery',
            'Sales' => 'Drive revenue growth through customer acquisition and retention',
            'Human Resources' => 'Manage talent acquisition, development, and employee relations',
            'Finance' => 'Manage financial planning, analysis, and reporting',
            'Customer Service' => 'Provide excellent support and assistance to customers',
            'Content Writing' => 'Create engaging written content for various platforms'
        ];
        
        foreach ($descriptions as $key => $desc) {
            if (stripos($categoryName, $key) !== false) {
                return $desc;
            }
        }
        
        return "Explore opportunities in the {$categoryName} field";
    }

    /**
     * Get qualifications for category
     */
    private function getQualificationsForCategory($categoryName)
    {
        $qualificationsMap = [
            'Software Development' => ['Computer Science Degree', 'Coding Bootcamp', 'Self-taught with Portfolio'],
            'Digital Marketing' => ['Marketing Degree', 'Digital Marketing Certification', 'Business Related Field'],
            'Data Science' => ['Mathematics/Statistics Degree', 'Computer Science', 'Data Science Bootcamp'],
            'Project Management' => ['PMP Certification', 'Business Degree', 'Agile Certification'],
            'UI/UX Design' => ['Design Degree', 'UX Certification', 'Portfolio-based'],
            'Cybersecurity' => ['Cybersecurity Degree', 'Security Certifications', 'IT Background']
        ];
        
        foreach ($qualificationsMap as $key => $quals) {
            if (stripos($categoryName, $key) !== false) {
                return $quals;
            }
        }
        
        return ['Relevant Degree', 'Professional Certification', 'Industry Experience'];
    }

    /**
     * Get experience level for category
     */
    private function getExperienceLevelForCategory($categoryName)
    {
        return 'Entry to Senior Level'; // Default for all categories
    }

    /**
     * Get salary range for category
     */
    private function getSalaryRangeForCategory($categoryName)
    {
        $salaryMap = [
            'Software Development' => 'TSh 800,000 - 5,000,000',
            'Digital Marketing' => 'TSh 600,000 - 3,500,000',
            'Data Science' => 'TSh 1,200,000 - 6,000,000',
            'Project Management' => 'TSh 1,000,000 - 4,500,000',
            'UI/UX Design' => 'TSh 700,000 - 4,000,000',
            'Cybersecurity' => 'TSh 1,500,000 - 7,000,000'
        ];
        
        foreach ($salaryMap as $key => $salary) {
            if (stripos($categoryName, $key) !== false) {
                return $salary;
            }
        }
        
        return 'TSh 500,000 - 3,000,000'; // Default range
    }

    /**
     * Get growth rate for category
     */
    private function getGrowthRateForCategory($categoryName)
    {
        $growthMap = [
            'Software Development' => '22%',
            'Digital Marketing' => '18%',
            'Data Science' => '25%',
            'Cybersecurity' => '28%',
            'UI/UX Design' => '20%'
        ];
        
        foreach ($growthMap as $key => $growth) {
            if (stripos($categoryName, $key) !== false) {
                return $growth;
            }
        }
        
        return '15%'; // Default growth rate
    }

    /**
     * Get recommendations for category
     */
    private function getRecommendationsForCategory($categoryName)
    {
        $recommendationsMap = [
            'Software Development' => [
                'Learn popular programming languages like JavaScript, Python, or Java',
                'Build a strong portfolio with personal projects',
                'Contribute to open-source projects on GitHub',
                'Stay updated with latest frameworks and technologies'
            ],
            'Digital Marketing' => [
                'Get certified in Google Ads and Google Analytics',
                'Learn social media advertising on Facebook, Instagram, LinkedIn',
                'Develop content creation and copywriting skills',
                'Understand data analysis and reporting tools'
            ]
        ];
        
        foreach ($recommendationsMap as $key => $recs) {
            if (stripos($categoryName, $key) !== false) {
                return $recs;
            }
        }
        
        return [
            'Develop relevant skills through online courses',
            'Build a professional network in your field',
            'Create a portfolio showcasing your abilities',
            'Stay updated with industry trends and best practices'
        ];
    }

    /**
     * Get learning resources for category
     */
    private function getLearningResourcesForCategory($categoryName)
    {
        return [
            'Online courses and tutorials',
            'Professional certifications',
            'Industry workshops and seminars',
            'Books and documentation',
            'Community forums and groups'
        ];
    }

    /**
     * Get default categories if database fails
     */
    private function getDefaultCareerCategories()
    {
        return [
            [
                'id' => 1,
                'name' => 'Software Development',
                'icon' => 'ri-code-s-slash-line',
                'color' => 'primary',
                'description' => 'Build applications, websites, and software solutions',
                'skills' => ['Programming Languages', 'Problem Solving', 'Database Management'],
                'qualifications' => ['Computer Science Degree', 'Coding Bootcamp'],
                'experience' => 'Entry to Senior Level',
                'salary_range' => 'TSh 800,000 - 5,000,000',
                'growth_rate' => '22%',
                'job_count' => 0,
                'recommendations' => ['Learn programming languages', 'Build a portfolio']
            ]
        ];
    }

    /**
     * Get user profile data including skills, experience, education
     */
    private function getUserProfile($user)
    {
        if (!$user) {
            return [
                'name' => 'Guest User',
                'firstname' => 'Guest',
                'lastname' => 'User',
                'skills' => ['JavaScript', 'HTML', 'CSS', 'Communication'],
                'experience_level' => 'Entry Level',
                'education' => 'Computer Science',
                'interests' => ['Technology', 'Web Development', 'Design'],
                'location' => 'Dar es Salaam',
                'preferred_salary' => 'TSh 1,000,000 - 3,000,000',
            ];
        }

        // Get user's full name using your model's structure
        $fullName = $user->getFullName();
        
        // Sample skills - you can modify this based on your database structure
        $userSkills = ['JavaScript', 'HTML', 'CSS', 'Communication'];

        return [
            'id' => $user->id,
            'name' => $fullName,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email,
            'skills' => $userSkills,
            'experience_level' => 'Entry Level',
            'education' => 'Computer Science',
            'interests' => ['Technology', 'Web Development', 'Design'],
            'location' => $user->location ?? 'Dar es Salaam',
            'preferred_salary' => 'TSh 1,000,000 - 3,000,000',
        ];
    }

    /**
     * Calculate match score between user profile and career category
     */
    private function calculateMatchScore($userProfile, $category)
    {
        $score = 0;
        
        // Skills matching (40% weight)
        $skillsMatch = 0;
        foreach ($userProfile['skills'] as $userSkill) {
            foreach ($category['skills'] as $categorySkill) {
                if (stripos($categorySkill, $userSkill) !== false || 
                    stripos($userSkill, $categorySkill) !== false) {
                    $skillsMatch += 10;
                }
            }
        }
        $score += min($skillsMatch, 40);
        
        // Education matching (20% weight)
        if (!empty($userProfile['education'])) {
            foreach ($category['qualifications'] as $qualification) {
                if (stripos($qualification, $userProfile['education']) !== false ||
                    stripos($userProfile['education'], $qualification) !== false) {
                    $score += 20;
                    break;
                }
            }
        }
        
        // Experience level matching (20% weight)
        if (stripos($category['experience'], $userProfile['experience_level']) !== false) {
            $score += 20;
        }
        
        // Interest matching (20% weight)
        foreach ($userProfile['interests'] as $interest) {
            if (stripos($category['name'], $interest) !== false ||
                stripos($category['description'], $interest) !== false) {
                $score += 10;
            }
        }
        
        return min($score, 95); // Cap at 95%
    }

    /**
     * Get personalized tips based on user profile and career category
     */
    private function getPersonalizedTips($userProfile, $category)
    {
        $tips = [];
        
        // Check missing skills
        $missingSkills = array_diff($category['skills'], $userProfile['skills']);
        if (!empty($missingSkills)) {
            $tips[] = 'Focus on developing these skills: ' . implode(', ', array_slice($missingSkills, 0, 3));
        }
        
        // Experience level recommendations
        if ($userProfile['experience_level'] === 'Entry Level') {
            $tips[] = 'Build a strong portfolio and consider internship opportunities';
            $tips[] = 'Join online communities and network with professionals in this field';
        }
        
        // Add category-specific tips
        $tips = array_merge($tips, array_slice($category['recommendations'], 0, 3));
        
        return $tips;
    }

    /**
     * Job Matching Action
     */
    public function actionJobMatching()
    {
        $user = Yii::$app->user->identity;
        $userProfile = $this->getUserProfile($user);
        
        // Use the correct view path
        return $this->render('/JobPortal/System/User/ai/job-matching', [
            'userProfile' => $userProfile,
        ]);
    }

    /**
     * Skills Assessment Action
     * Provides AI-powered skills evaluation and recommendations
     */
    public function actionSkillsAssessment()
    {
        $user = Yii::$app->user->identity;
        $userProfile = $this->getUserProfile($user);
        
        // Get available categories for selection
        $availableCategories = $this->getAvailableCategories();
        
        if (Yii::$app->request->isPost) {
            // Handle assessment submission
            return $this->processSkillsAssessment();
        }
        
        return $this->render('/JobPortal/System/User/ai/skills-assessment', [
            'userName' => $userProfile['name'],
            'userProfile' => $userProfile,
            'availableCategories' => $availableCategories
        ]);
    }

    /**
     * Get Assessment Questions Action
     * Returns questions for selected categories via AJAX
     */
    public function actionGetAssessmentQuestions()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        if (!Yii::$app->request->isAjax) {
            return [
                'success' => false,
                'message' => 'Invalid request method'
            ];
        }
        
        $selectedCategoryIds = Yii::$app->request->post('categories', []);
        
        if (empty($selectedCategoryIds)) {
            return [
                'success' => false,
                'message' => 'No categories selected'
            ];
        }
        
        try {
            // Get assessment categories with questions
            $categories = $this->getAssessmentCategoriesWithQuestions($selectedCategoryIds);
            
            return [
                'success' => true,
                'categories' => $categories
            ];
        } catch (\Exception $e) {
            Yii::error("Error fetching assessment questions: " . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Failed to load assessment questions: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Get available categories for selection
     */
    private function getAvailableCategories()
    {
        try {
            $db = Yii::$app->db;
            
            // Get categories from database
            $categories = $db->createCommand("
                SELECT id, name, description, icon, status, sort_order 
                FROM job_categories 
                WHERE status = 'active' 
                ORDER BY sort_order ASC, name ASC
            ")->queryAll();
            
            $availableCategories = [];
            foreach ($categories as $category) {
                $availableCategories[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'description' => $category['description'] ?? '',
                    'icon' => $category['icon'] ?: $this->getDefaultIconForCategory($category['name']),
                    'color' => $this->getColorForCategory($category['name']),
                ];
            }
            
            return $availableCategories;
            
        } catch (\Exception $e) {
            Yii::error("Error fetching available categories: " . $e->getMessage());
            return $this->getDefaultCategories();
        }
    }
    
    /**
     * Get assessment categories with questions for selected category IDs
     */
    private function getAssessmentCategoriesWithQuestions($categoryIds)
    {
        try {
            $db = Yii::$app->db;
            
            // Get selected categories from database
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $categories = $db->createCommand("
                SELECT id, name, description, icon, status 
                FROM job_categories 
                WHERE id IN ($placeholders) AND status = 'active' 
                ORDER BY sort_order ASC, name ASC
            ")->bindValues($categoryIds)->queryAll();
            
            $assessmentCategories = [];
            foreach ($categories as $category) {
                // Try to get questions from skills table if it exists
                $questions = $this->getQuestionsForCategory($category['id']);
                
                // If no questions found, use default questions
                if (empty($questions)) {
                    $questions = $this->getDefaultQuestionsForCategory($category['name']);
                }
                
                $assessmentCategories[] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'description' => $category['description'] ?? $this->getDefaultDescriptionForCategory($category['name']),
                    'icon' => $category['icon'] ?: $this->getDefaultIconForCategory($category['name']),
                    'color' => $this->getColorForCategory($category['name']),
                    'questions' => $questions
                ];
            }
            
            return $assessmentCategories;
            
        } catch (\Exception $e) {
            Yii::error("Error fetching assessment categories: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Get questions for a specific category from database
     */
    private function getQuestionsForCategory($categoryId)
    {
        try {
            $db = Yii::$app->db;
            
            // Check if skills table exists and has questions
            try {
                $skillsData = $db->createCommand("
                    SELECT name, description 
                    FROM skills 
                    WHERE category_id = :category_id AND status = 'active' 
                    ORDER BY sort_order ASC, name ASC 
                    LIMIT 10
                ")->bindValue(':category_id', $categoryId)->queryAll();
                
                if (!empty($skillsData)) {
                    $questions = [];
                    foreach ($skillsData as $skill) {
                        if (!empty($skill['description'])) {
                            $questions[] = "How would you rate your proficiency in " . $skill['name'] . "?";
                        } else {
                            $questions[] = "Rate your skill level in " . $skill['name'];
                        }
                    }
                    return $questions;
                }
            } catch (\Exception $e) {
                Yii::warning("Error fetching skills for questions: " . $e->getMessage());
            }
            
            return [];
            
        } catch (\Exception $e) {
            Yii::error("Error in getQuestionsForCategory: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get default questions for a category based on its name
     */
    private function getDefaultQuestionsForCategory($categoryName)
    {
        $questionsMap = [
            'Information Technology' => [
                'How comfortable are you with programming languages?',
                'Can you manage databases effectively?',
                'How well do you understand web development?',
                'Are you familiar with cloud computing services?',
                'How would you rate your problem-solving skills in IT?'
            ],
            'Healthcare' => [
                'How comfortable are you with patient care?',
                'Can you handle medical emergencies effectively?',
                'How well do you communicate with patients?',
                'Are you familiar with medical equipment?',
                'How do you handle stressful situations?'
            ],
            'Finance & Banking' => [
                'How comfortable are you with financial analysis?',
                'Can you work with complex spreadsheets?',
                'How well do you understand risk management?',
                'Are you familiar with banking regulations?',
                'How do you handle confidential information?'
            ],
            'Software Development' => [
                'How would you rate your programming skills?',
                'How comfortable are you with database management?',
                'Rate your proficiency in version control systems (e.g., Git)',
                'How well do you understand software architecture?',
                'How would you rate your debugging skills?'
            ],
            'Digital Marketing' => [
                'How would you rate your SEO knowledge?',
                'How proficient are you with social media marketing?',
                'Rate your content creation abilities',
                'How well do you understand digital analytics?',
                'How comfortable are you with paid advertising platforms?'
            ],
            'Data Science' => [
                'How would you rate your statistical analysis skills?',
                'How proficient are you with Python or R programming?',
                'Rate your understanding of machine learning algorithms',
                'How comfortable are you with data visualization?',
                'How well can you communicate technical findings to non-technical audiences?'
            ],
            'Project Management' => [
                'How would you rate your leadership skills?',
                'How well do you manage project timelines and deadlines?',
                'Rate your ability to handle project risks and issues',
                'How proficient are you with project management tools?',
                'How well do you communicate with stakeholders?'
            ]
        ];
        
        foreach ($questionsMap as $key => $questions) {
            if (stripos($categoryName, $key) !== false || stripos($key, $categoryName) !== false) {
                return $questions;
            }
        }
        
        // Default questions if no specific category match
        return [
            'How would you rate your communication skills?',
            'Can you work effectively in a team?',
            'How do you handle challenging situations?',
            'Are you comfortable learning new skills?',
            'How well do you manage your time?'
        ];
    }

    /**
     * Process skills assessment submission
     */
    private function processSkillsAssessment()
    {
        $data = Yii::$app->request->post();
        
        // Calculate scores and provide recommendations
        $results = [
            'overall_score' => 0,
            'category_scores' => [],
            'strengths' => [],
            'improvement_areas' => [],
            'recommendations' => []
        ];
        
        // Process each category assessment
        if (isset($data['assessment'])) {
            foreach ($data['assessment'] as $categoryId => $answers) {
                $categoryScore = $this->calculateCategoryScore($answers);
                
                // Get category name
                try {
                    $categoryName = Yii::$app->db->createCommand("
                        SELECT name FROM job_categories WHERE id = :id
                    ")->bindValue(':id', $categoryId)->queryScalar();
                } catch (\Exception $e) {
                    $categoryName = "Category #" . $categoryId;
                }
                
                $results['category_scores'][$categoryId] = [
                    'name' => $categoryName,
                    'score' => $categoryScore,
                    'color' => $this->getColorForCategory($categoryName),
                    'icon' => $this->getDefaultIconForCategory($categoryName)
                ];
                
                // Identify strengths and improvement areas
                if ($categoryScore >= 80) {
                    $results['strengths'][] = $categoryName;
                } elseif ($categoryScore <= 50) {
                    $results['improvement_areas'][] = $categoryName;
                }
            }
            
            // Calculate overall score
            if (!empty($results['category_scores'])) {
                $totalScore = 0;
                foreach ($results['category_scores'] as $score) {
                    $totalScore += $score['score'];
                }
                $results['overall_score'] = round($totalScore / count($results['category_scores']));
            }
            
            // Generate recommendations based on scores
            $results['recommendations'] = $this->generateSkillsRecommendations($results);
        }
        
        return $this->renderAjax('/JobPortal/System/User/ai/skills-assessment-results', [
            'results' => $results
        ]);
    }

    /**
     * Calculate score for a category
     */
    private function calculateCategoryScore($answers)
    {
        $totalScore = 0;
        $totalQuestions = count($answers);
        
        foreach ($answers as $answer) {
            $totalScore += (int)$answer; // Assuming 1-5 scale
        }
        
        return $totalQuestions > 0 ? round(($totalScore / ($totalQuestions * 5)) * 100) : 0;
    }

    /**
     * Generate skills recommendations
     */
    private function generateSkillsRecommendations($results)
    {
        $recommendations = [];
        
        if ($results['overall_score'] >= 80) {
            $recommendations[] = "Excellent! You have strong skills across multiple areas.";
            $recommendations[] = "Consider taking on leadership roles or mentoring others.";
            $recommendations[] = "Look for advanced certifications to further enhance your expertise.";
        } elseif ($results['overall_score'] >= 60) {
            $recommendations[] = "Good foundation! Focus on strengthening specific skill areas.";
            $recommendations[] = "Consider additional training in your weaker areas.";
            $recommendations[] = "Look for projects that challenge your current skill level.";
        } else {
            $recommendations[] = "Great potential! Focus on building fundamental skills.";
            $recommendations[] = "Consider enrolling in training courses or online programs.";
            $recommendations[] = "Practice regularly and seek feedback from experienced professionals.";
        }
        
        // Add specific recommendations for improvement areas
        if (!empty($results['improvement_areas'])) {
            $recommendations[] = "Focus on improving your skills in: " . implode(', ', array_slice($results['improvement_areas'], 0, 3));
            
            // Add specific learning resources for top improvement area
            if (isset($results['improvement_areas'][0])) {
                $topArea = $results['improvement_areas'][0];
                $recommendations[] = "For " . $topArea . ", we recommend starting with online courses and practical projects.";
            }
        }
        
        // Add career path recommendation if they have strengths
        if (!empty($results['strengths'])) {
            $recommendations[] = "Your strengths in " . implode(' and ', array_slice($results['strengths'], 0, 2)) . 
                                " could lead to promising career opportunities.";
        }
        
        return $recommendations;
    }

    /**
     * Get default categories
     */
    private function getDefaultCategories()
    {
        return [
            [
                'id' => 1,
                'name' => 'General Skills',
                'description' => 'Basic professional skills assessment',
                'icon' => 'ri-user-line',
                'color' => 'primary',
            ],
            [
                'id' => 2,
                'name' => 'Technical Skills',
                'description' => 'Evaluate your technical abilities',
                'icon' => 'ri-code-s-slash-line',
                'color' => 'info',
            ],
            [
                'id' => 3,
                'name' => 'Communication',
                'description' => 'Assess your communication capabilities',
                'icon' => 'ri-chat-3-line',
                'color' => 'success',
            ]
        ];
    }
}


