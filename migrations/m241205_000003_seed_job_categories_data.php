<?php

use yii\db\Migration;

/**
 * Class m241205_000003_seed_job_categories_data
 */
class m241205_000003_seed_job_categories_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Insert sample job categories
        $categories = [
            [
                'name' => 'Information Technology',
                'slug' => 'information-technology',
                'description' => 'Technology and software development jobs including programming, web development, database administration, and IT support.',
                'icon' => 'ri-computer-line',
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'IT Jobs - Information Technology Careers',
                'meta_description' => 'Find the latest Information Technology jobs including software development, programming, and IT support positions.',
            ],
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'description' => 'Medical and healthcare professional jobs including doctors, nurses, medical technicians, and healthcare administration.',
                'icon' => 'ri-heart-pulse-line',
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Healthcare Jobs - Medical Careers',
                'meta_description' => 'Explore healthcare career opportunities including nursing, medical, and healthcare administration positions.',
            ],
            [
                'name' => 'Finance & Banking',
                'slug' => 'finance-banking',
                'description' => 'Financial services and banking jobs including accounting, financial analysis, investment banking, and insurance.',
                'icon' => 'ri-bank-line',
                'status' => 'active',
                'sort_order' => 3,
                'meta_title' => 'Finance Jobs - Banking & Financial Services',
                'meta_description' => 'Discover finance and banking career opportunities in accounting, investment, and financial services.',
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Teaching and educational jobs including teachers, professors, educational administrators, and training specialists.',
                'icon' => 'ri-book-open-line',
                'status' => 'active',
                'sort_order' => 4,
                'meta_title' => 'Education Jobs - Teaching Careers',
                'meta_description' => 'Find teaching and education career opportunities in schools, universities, and training organizations.',
            ],
            [
                'name' => 'Engineering',
                'slug' => 'engineering',
                'description' => 'Engineering and technical jobs including civil, mechanical, electrical, software, and other engineering disciplines.',
                'icon' => 'ri-settings-3-line',
                'status' => 'active',
                'sort_order' => 5,
                'meta_title' => 'Engineering Jobs - Technical Careers',
                'meta_description' => 'Explore engineering career opportunities in various technical and engineering disciplines.',
            ],
            [
                'name' => 'Marketing & Sales',
                'slug' => 'marketing-sales',
                'description' => 'Marketing, sales and business development jobs including digital marketing, sales representatives, and marketing managers.',
                'icon' => 'ri-megaphone-line',
                'status' => 'active',
                'sort_order' => 6,
                'meta_title' => 'Marketing & Sales Jobs - Business Development',
                'meta_description' => 'Find marketing and sales career opportunities in digital marketing, business development, and sales.',
            ],
            [
                'name' => 'Human Resources',
                'slug' => 'human-resources',
                'description' => 'HR and recruitment jobs including HR managers, recruiters, training specialists, and employee relations.',
                'icon' => 'ri-team-line',
                'status' => 'active',
                'sort_order' => 7,
                'meta_title' => 'HR Jobs - Human Resources Careers',
                'meta_description' => 'Discover human resources career opportunities in recruitment, training, and employee relations.',
            ],
            [
                'name' => 'Construction',
                'slug' => 'construction',
                'description' => 'Construction and building jobs including construction workers, project managers, architects, and skilled trades.',
                'icon' => 'ri-building-3-line',
                'status' => 'active',
                'sort_order' => 8,
                'meta_title' => 'Construction Jobs - Building & Trades',
                'meta_description' => 'Find construction and building career opportunities in skilled trades and project management.',
            ],
        ];

        foreach ($categories as $category) {
            $this->insert('{{%job_categories}}', $category);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%job_categories}}', ['slug' => [
            'information-technology',
            'healthcare',
            'finance-banking',
            'education',
            'engineering',
            'marketing-sales',
            'human-resources',
            'construction',
        ]]);
    }
}