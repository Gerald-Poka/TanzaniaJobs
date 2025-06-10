<?php

use yii\db\Migration;

/**
 * Class m241205_000004_seed_skills_data
 */
class m241205_000004_seed_skills_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Get category IDs
        $itCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'information-technology'")->queryScalar();
        $healthcareCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'healthcare'")->queryScalar();
        $financeCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'finance-banking'")->queryScalar();
        $educationCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'education'")->queryScalar();
        $engineeringCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'engineering'")->queryScalar();
        $marketingCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'marketing-sales'")->queryScalar();
        $hrCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'human-resources'")->queryScalar();
        $constructionCategoryId = $this->db->createCommand("SELECT id FROM {{%job_categories}} WHERE slug = 'construction'")->queryScalar();

        // Insert sample skills
        $skills = [
            // IT Skills
            ['name' => 'PHP', 'slug' => 'php', 'category_id' => $itCategoryId, 'description' => 'PHP programming language for web development'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'category_id' => $itCategoryId, 'description' => 'JavaScript programming for web applications'],
            ['name' => 'React', 'slug' => 'react', 'category_id' => $itCategoryId, 'description' => 'React.js framework for building user interfaces'],
            ['name' => 'Node.js', 'slug' => 'nodejs', 'category_id' => $itCategoryId, 'description' => 'Node.js runtime for server-side JavaScript'],
            ['name' => 'Python', 'slug' => 'python', 'category_id' => $itCategoryId, 'description' => 'Python programming language'],
            ['name' => 'MySQL', 'slug' => 'mysql', 'category_id' => $itCategoryId, 'description' => 'MySQL database management'],
            ['name' => 'Docker', 'slug' => 'docker', 'category_id' => $itCategoryId, 'description' => 'Docker containerization technology'],
            ['name' => 'AWS', 'slug' => 'aws', 'category_id' => $itCategoryId, 'description' => 'Amazon Web Services cloud platform'],

            // Healthcare Skills
            ['name' => 'Nursing', 'slug' => 'nursing', 'category_id' => $healthcareCategoryId, 'description' => 'Professional nursing skills and patient care'],
            ['name' => 'Surgery', 'slug' => 'surgery', 'category_id' => $healthcareCategoryId, 'description' => 'Surgical procedures and techniques'],
            ['name' => 'Emergency Medicine', 'slug' => 'emergency-medicine', 'category_id' => $healthcareCategoryId, 'description' => 'Emergency medical care and trauma response'],
            ['name' => 'Radiology', 'slug' => 'radiology', 'category_id' => $healthcareCategoryId, 'description' => 'Medical imaging and diagnostic radiology'],

            // Finance Skills
            ['name' => 'Accounting', 'slug' => 'accounting', 'category_id' => $financeCategoryId, 'description' => 'Financial accounting and bookkeeping'],
            ['name' => 'Financial Analysis', 'slug' => 'financial-analysis', 'category_id' => $financeCategoryId, 'description' => 'Financial analysis and reporting'],
            ['name' => 'Investment Banking', 'slug' => 'investment-banking', 'category_id' => $financeCategoryId, 'description' => 'Investment banking and securities'],
            ['name' => 'Risk Management', 'slug' => 'risk-management', 'category_id' => $financeCategoryId, 'description' => 'Financial risk assessment and management'],

            // Education Skills
            ['name' => 'Teaching', 'slug' => 'teaching', 'category_id' => $educationCategoryId, 'description' => 'Teaching and instruction skills'],
            ['name' => 'Curriculum Development', 'slug' => 'curriculum-development', 'category_id' => $educationCategoryId, 'description' => 'Educational curriculum design and development'],
            ['name' => 'Educational Technology', 'slug' => 'educational-technology', 'category_id' => $educationCategoryId, 'description' => 'Technology integration in education'],

            // Engineering Skills
            ['name' => 'Civil Engineering', 'slug' => 'civil-engineering', 'category_id' => $engineeringCategoryId, 'description' => 'Civil engineering and infrastructure'],
            ['name' => 'Mechanical Engineering', 'slug' => 'mechanical-engineering', 'category_id' => $engineeringCategoryId, 'description' => 'Mechanical systems and design'],
            ['name' => 'Electrical Engineering', 'slug' => 'electrical-engineering', 'category_id' => $engineeringCategoryId, 'description' => 'Electrical systems and electronics'],

            // Marketing Skills
            ['name' => 'Digital Marketing', 'slug' => 'digital-marketing', 'category_id' => $marketingCategoryId, 'description' => 'Online marketing and digital campaigns'],
            ['name' => 'SEO', 'slug' => 'seo', 'category_id' => $marketingCategoryId, 'description' => 'Search engine optimization'],
            ['name' => 'Social Media Marketing', 'slug' => 'social-media-marketing', 'category_id' => $marketingCategoryId, 'description' => 'Social media marketing and management'],

            // HR Skills
            ['name' => 'Recruitment', 'slug' => 'recruitment', 'category_id' => $hrCategoryId, 'description' => 'Talent acquisition and recruitment'],
            ['name' => 'Employee Relations', 'slug' => 'employee-relations', 'category_id' => $hrCategoryId, 'description' => 'Employee relations and conflict resolution'],
            ['name' => 'Training & Development', 'slug' => 'training-development', 'category_id' => $hrCategoryId, 'description' => 'Employee training and development programs'],

            // Construction Skills
            ['name' => 'Project Management', 'slug' => 'project-management', 'category_id' => $constructionCategoryId, 'description' => 'Construction project management'],
            ['name' => 'Carpentry', 'slug' => 'carpentry', 'category_id' => $constructionCategoryId, 'description' => 'Carpentry and woodworking skills'],
            ['name' => 'Plumbing', 'slug' => 'plumbing', 'category_id' => $constructionCategoryId, 'description' => 'Plumbing installation and repair'],
        ];

        foreach ($skills as $index => $skill) {
            $skill['status'] = 'active';
            $skill['sort_order'] = $index + 1;
            $this->insert('{{%skills}}', $skill);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%skills}}', ['slug' => [
            'php', 'javascript', 'react', 'nodejs', 'python', 'mysql', 'docker', 'aws',
            'nursing', 'surgery', 'emergency-medicine', 'radiology',
            'accounting', 'financial-analysis', 'investment-banking', 'risk-management',
            'teaching', 'curriculum-development', 'educational-technology',
            'civil-engineering', 'mechanical-engineering', 'electrical-engineering',
            'digital-marketing', 'seo', 'social-media-marketing',
            'recruitment', 'employee-relations', 'training-development',
            'project-management', 'carpentry', 'plumbing',
        ]]);
    }
}