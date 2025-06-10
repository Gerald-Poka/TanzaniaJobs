<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_categories}}`.
 */
class m241205_000001_create_job_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job_categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'description' => $this->text(),
            'icon' => $this->string(100),
            'parent_id' => $this->integer(),
            'status' => $this->string(20)->notNull()->defaultValue('active'),
            'sort_order' => $this->integer()->defaultValue(0),
            'meta_title' => $this->string(255),
            'meta_description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Add indexes
        $this->createIndex(
            'idx-job_categories-parent_id',
            '{{%job_categories}}',
            'parent_id'
        );

        $this->createIndex(
            'idx-job_categories-status',
            '{{%job_categories}}',
            'status'
        );

        $this->createIndex(
            'idx-job_categories-slug',
            '{{%job_categories}}',
            'slug'
        );

        $this->createIndex(
            'idx-job_categories-sort_order',
            '{{%job_categories}}',
            'sort_order'
        );

        // Add foreign key for parent_id (self-referencing)
        $this->addForeignKey(
            'fk-job_categories-parent_id',
            '{{%job_categories}}',
            'parent_id',
            '{{%job_categories}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key first
        $this->dropForeignKey(
            'fk-job_categories-parent_id',
            '{{%job_categories}}'
        );

        // Drop indexes
        $this->dropIndex(
            'idx-job_categories-parent_id',
            '{{%job_categories}}'
        );

        $this->dropIndex(
            'idx-job_categories-status',
            '{{%job_categories}}'
        );

        $this->dropIndex(
            'idx-job_categories-slug',
            '{{%job_categories}}'
        );

        $this->dropIndex(
            'idx-job_categories-sort_order',
            '{{%job_categories}}'
        );

        $this->dropTable('{{%job_categories}}');
    }
}