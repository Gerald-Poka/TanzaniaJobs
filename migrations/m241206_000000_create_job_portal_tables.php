<?php

use yii\db\Migration;

/**
 * Create tables for job portal system
 */
class m241206_000000_create_job_portal_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create companies table
        $this->createTable('{{%companies}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'logo' => $this->string(255),
            'website' => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(50),
            'address' => $this->text(),
            'city' => $this->string(100),
            'country' => $this->string(100),
            'size_range' => $this->string(50),
            'industry' => $this->string(100),
            'founded_year' => $this->integer(),
            'status' => "ENUM('active', 'inactive', 'pending', 'suspended') DEFAULT 'pending'",
            'verified' => $this->boolean()->defaultValue(false),
            'featured' => $this->boolean()->defaultValue(false),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Create indexes for companies
        $this->createIndex('idx_companies_status', '{{%companies}}', 'status');
        $this->createIndex('idx_companies_verified', '{{%companies}}', 'verified');
        $this->createIndex('idx_companies_featured', '{{%companies}}', 'featured');

        // Create jobs table
        $this->createTable('{{%jobs}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text()->notNull(),
            'short_description' => $this->text(),
            'requirements' => $this->text(),
            'benefits' => $this->text(),
            
            'company_id' => $this->integer(),
            'category_id' => $this->integer(),
            'posted_by' => $this->integer(),
            
            'job_type' => "ENUM('full-time', 'part-time', 'contract', 'freelance', 'internship', 'temporary') DEFAULT 'full-time'",
            'location_type' => "ENUM('onsite', 'remote', 'hybrid') DEFAULT 'onsite'",
            'location' => $this->string(255),
            
            'salary_min' => $this->decimal(12, 2),
            'salary_max' => $this->decimal(12, 2),
            'salary_currency' => $this->string(3)->defaultValue('USD'),
            'salary_period' => "ENUM('hourly', 'daily', 'weekly', 'monthly', 'yearly') DEFAULT 'monthly'",
            
            'experience_level' => "ENUM('entry', 'junior', 'mid', 'senior', 'lead', 'executive') DEFAULT 'mid'",
            'education_level' => "ENUM('high-school', 'diploma', 'bachelor', 'master', 'phd', 'other') DEFAULT 'bachelor'",
            
            'status' => "ENUM('draft', 'pending', 'published', 'expired', 'rejected', 'reported') DEFAULT 'pending'",
            'featured' => $this->boolean()->defaultValue(false),
            'urgent' => $this->boolean()->defaultValue(false),
            
            'views_count' => $this->integer()->defaultValue(0),
            'applications_count' => $this->integer()->defaultValue(0),
            
            'expires_at' => $this->dateTime(),
            'rejection_reason' => $this->text(),
            
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Create indexes for jobs
        $this->createIndex('idx_jobs_status', '{{%jobs}}', 'status');
        $this->createIndex('idx_jobs_company_id', '{{%jobs}}', 'company_id');
        $this->createIndex('idx_jobs_category_id', '{{%jobs}}', 'category_id');
        $this->createIndex('idx_jobs_job_type', '{{%jobs}}', 'job_type');
        $this->createIndex('idx_jobs_location_type', '{{%jobs}}', 'location_type');
        $this->createIndex('idx_jobs_featured', '{{%jobs}}', 'featured');
        $this->createIndex('idx_jobs_expires_at', '{{%jobs}}', 'expires_at');
        $this->createIndex('idx_jobs_created_at', '{{%jobs}}', 'created_at');

        // Create job_skills junction table
        $this->createTable('{{%job_skills}}', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer()->notNull(),
            'skill_id' => $this->integer()->notNull(),
            'required' => $this->boolean()->defaultValue(true),
            'proficiency_level' => "ENUM('basic', 'intermediate', 'advanced', 'expert') DEFAULT 'intermediate'",
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create unique constraint for job_skills
        $this->createIndex('unique_job_skill', '{{%job_skills}}', ['job_id', 'skill_id'], true);
        $this->createIndex('idx_job_skills_job_id', '{{%job_skills}}', 'job_id');
        $this->createIndex('idx_job_skills_skill_id', '{{%job_skills}}', 'skill_id');

        // Create job_applications table
        $this->createTable('{{%job_applications}}', [
            'id' => $this->primaryKey(),
            'job_id' => $this->integer()->notNull(),
            'applicant_id' => $this->integer()->notNull(),
            
            'cover_letter' => $this->text(),
            'resume_file' => $this->string(255),
            'expected_salary' => $this->decimal(12, 2),
            'availability_date' => $this->date(),
            
            'status' => "ENUM('pending', 'reviewed', 'shortlisted', 'interviewed', 'offered', 'hired', 'rejected') DEFAULT 'pending'",
            'notes' => $this->text(),
            
            'applied_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Create unique constraint for job_applications
        $this->createIndex('unique_application', '{{%job_applications}}', ['job_id', 'applicant_id'], true);
        $this->createIndex('idx_job_applications_job_id', '{{%job_applications}}', 'job_id');
        $this->createIndex('idx_job_applications_applicant_id', '{{%job_applications}}', 'applicant_id');
        $this->createIndex('idx_job_applications_status', '{{%job_applications}}', 'status');
        $this->createIndex('idx_job_applications_applied_at', '{{%job_applications}}', 'applied_at');

        // Add foreign key constraints
        $this->addForeignKey(
            'fk_jobs_company_id',
            '{{%jobs}}',
            'company_id',
            '{{%companies}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        // Check if job_categories table exists before adding foreign key
        $tableSchema = $this->db->getTableSchema('{{%job_categories}}');
        if ($tableSchema !== null) {
            $this->addForeignKey(
                'fk_jobs_category_id',
                '{{%jobs}}',
                'category_id',
                '{{%job_categories}}',
                'id',
                'SET NULL',
                'CASCADE'
            );
        }

        // Check if skills table exists before adding foreign key
        $skillsSchema = $this->db->getTableSchema('{{%skills}}');
        if ($skillsSchema !== null) {
            $this->addForeignKey(
                'fk_job_skills_skill_id',
                '{{%job_skills}}',
                'skill_id',
                '{{%skills}}',
                'id',
                'CASCADE',
                'CASCADE'
            );
        }

        $this->addForeignKey(
            'fk_job_skills_job_id',
            '{{%job_skills}}',
            'job_id',
            '{{%jobs}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_job_applications_job_id',
            '{{%job_applications}}',
            'job_id',
            '{{%jobs}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Insert sample data
        $this->insertSampleData();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys first
        $this->dropForeignKey('fk_job_applications_job_id', '{{%job_applications}}');
        $this->dropForeignKey('fk_job_skills_job_id', '{{%job_skills}}');
        
        // Check and drop foreign keys that might exist
        try {
            $this->dropForeignKey('fk_job_skills_skill_id', '{{%job_skills}}');
        } catch (\Exception $e) {
            // Foreign key might not exist if skills table doesn't exist
        }
        
        try {
            $this->dropForeignKey('fk_jobs_category_id', '{{%jobs}}');
        } catch (\Exception $e) {
            // Foreign key might not exist if job_categories table doesn't exist
        }
        
        $this->dropForeignKey('fk_jobs_company_id', '{{%jobs}}');

        // Drop tables in reverse order
        $this->dropTable('{{%job_applications}}');
        $this->dropTable('{{%job_skills}}');
        $this->dropTable('{{%jobs}}');
        $this->dropTable('{{%companies}}');
    }

    /**
     * Insert sample data for testing
     */
    private function insertSampleData()
    {
        // Insert sample companies
        $this->batchInsert('{{%companies}}', [
            'name', 'slug', 'description', 'status', 'verified', 'created_at', 'updated_at'
        ], [
            ['TechCorp Ltd', 'techcorp-ltd', 'Leading technology company specializing in software development and innovation.', 'active', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['StartupVenture Inc', 'startupventure-inc', 'Innovative startup company focused on disruptive technologies.', 'active', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['Global Solutions', 'global-solutions', 'International consulting firm providing business solutions worldwide.', 'pending', 0, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['Digital Agency Pro', 'digital-agency-pro', 'Full-service digital marketing and web development agency.', 'active', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
            ['Enterprise Corp', 'enterprise-corp', 'Large enterprise corporation with multiple business units.', 'active', 1, date('Y-m-d H:i:s'), date('Y-m-d H:i:s')],
        ]);

        // Insert sample jobs
        $this->batchInsert('{{%jobs}}', [
            'title', 'slug', 'description', 'short_description', 'company_id', 'job_type', 'location_type', 'location', 
            'salary_min', 'salary_max', 'salary_currency', 'experience_level', 'status', 'featured', 'views_count', 
            'applications_count', 'expires_at', 'created_at', 'updated_at'
        ], [
            [
                'Senior PHP Developer',
                'senior-php-developer-' . time(),
                'We are looking for a Senior PHP Developer to join our growing team. You will be responsible for developing and maintaining web applications using PHP, MySQL, and modern frameworks like Yii2 or Laravel. The ideal candidate should have strong problem-solving skills and experience with object-oriented programming.',
                'Senior PHP Developer position with competitive salary and benefits',
                1, // TechCorp Ltd
                'full-time',
                'hybrid',
                'New York, NY',
                80000,
                120000,
                'USD',
                'senior',
                'published',
                1,
                156,
                23,
                date('Y-m-d H:i:s', strtotime('+30 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ],
            [
                'Frontend React Developer',
                'frontend-react-developer-' . time(),
                'Join our frontend team as a React Developer. You will work on building modern, responsive web applications using React, Redux, and other cutting-edge technologies. Experience with TypeScript and testing frameworks is a plus.',
                'React Developer for modern web applications',
                2, // StartupVenture Inc
                'full-time',
                'remote',
                'Remote',
                60000,
                90000,
                'USD',
                'mid',
                'pending',
                0,
                89,
                12,
                date('Y-m-d H:i:s', strtotime('+45 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ],
            [
                'DevOps Engineer',
                'devops-engineer-' . time(),
                'We need a DevOps Engineer to manage our cloud infrastructure and CI/CD pipelines. Experience with AWS, Docker, Kubernetes, and Jenkins is required. You will work closely with development teams to ensure smooth deployments and system reliability.',
                'DevOps Engineer for cloud infrastructure management',
                1, // TechCorp Ltd
                'full-time',
                'onsite',
                'San Francisco, CA',
                90000,
                140000,
                'USD',
                'senior',
                'expired',
                0,
                234,
                45,
                date('Y-m-d H:i:s', strtotime('-1 day')),
                date('Y-m-d H:i:s', strtotime('-15 days')),
                date('Y-m-d H:i:s')
            ],
            [
                'UI/UX Designer',
                'ui-ux-designer-' . time(),
                'Creative UI/UX Designer needed to design intuitive and beautiful user interfaces. You will work on web and mobile applications, creating wireframes, prototypes, and final designs. Proficiency in Figma, Adobe Creative Suite, and user research methodologies is essential.',
                'UI/UX Designer for web and mobile applications',
                4, // Digital Agency Pro
                'part-time',
                'hybrid',
                'Los Angeles, CA',
                45000,
                70000,
                'USD',
                'mid',
                'published',
                1,
                78,
                18,
                date('Y-m-d H:i:s', strtotime('+25 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ],
            [
                'Data Scientist',
                'data-scientist-' . time(),
                'Data Scientist position available for analyzing large datasets and building machine learning models. You will work with Python, R, SQL, and various ML frameworks. Experience with data visualization tools and statistical analysis is required.',
                'Data Scientist for machine learning and analytics',
                5, // Enterprise Corp
                'full-time',
                'remote',
                'Remote',
                95000,
                130000,
                'USD',
                'senior',
                'published',
                1,
                167,
                31,
                date('Y-m-d H:i:s', strtotime('+20 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ],
            [
                'Junior Web Developer',
                'junior-web-developer-' . time(),
                'Entry-level position for a Junior Web Developer. Perfect opportunity for recent graduates or career changers. You will learn and work with HTML, CSS, JavaScript, and PHP. Mentorship and training will be provided.',
                'Entry-level web developer position with training',
                2, // StartupVenture Inc
                'full-time',
                'onsite',
                'Austin, TX',
                45000,
                60000,
                'USD',
                'entry',
                'pending',
                0,
                92,
                28,
                date('Y-m-d H:i:s', strtotime('+35 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ],
            [
                'Project Manager',
                'project-manager-' . time(),
                'Experienced Project Manager needed to lead software development projects. You will coordinate with cross-functional teams, manage timelines, and ensure project deliverables meet quality standards. PMP certification preferred.',
                'Project Manager for software development projects',
                3, // Global Solutions
                'full-time',
                'hybrid',
                'Chicago, IL',
                70000,
                95000,
                'USD',
                'senior',
                'reported',
                0,
                45,
                8,
                date('Y-m-d H:i:s', strtotime('+40 days')),
                date('Y-m-d H:i:s'),
                date('Y-m-d H:i:s')
            ]
        ]);

        echo "Sample data inserted successfully!\n";
    }
}