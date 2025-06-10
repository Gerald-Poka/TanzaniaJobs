<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%skills}}`.
 */
class m241205_000002_create_skills_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%skills}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull()->unique(),
            'category_id' => $this->integer(),
            'description' => $this->text(),
            'status' => $this->string(20)->notNull()->defaultValue('active'),
            'sort_order' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Add indexes
        $this->createIndex(
            'idx-skills-category_id',
            '{{%skills}}',
            'category_id'
        );

        $this->createIndex(
            'idx-skills-status',
            '{{%skills}}',
            'status'
        );

        $this->createIndex(
            'idx-skills-slug',
            '{{%skills}}',
            'slug'
        );

        $this->createIndex(
            'idx-skills-sort_order',
            '{{%skills}}',
            'sort_order'
        );

        // Add foreign key for category_id
        $this->addForeignKey(
            'fk-skills-category_id',
            '{{%skills}}',
            'category_id',
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
            'fk-skills-category_id',
            '{{%skills}}'
        );

        // Drop indexes
        $this->dropIndex(
            'idx-skills-category_id',
            '{{%skills}}'
        );

        $this->dropIndex(
            'idx-skills-status',
            '{{%skills}}'
        );

        $this->dropIndex(
            'idx-skills-slug',
            '{{%skills}}'
        );

        $this->dropIndex(
            'idx-skills-sort_order',
            '{{%skills}}'
        );

        $this->dropTable('{{%skills}}');
    }
}