<?php

use yii\db\Migration;

/**
 * Class m250602_063240_create_work_experience_table
 */
class m250602_063240_create_work_experience_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%work_experiences}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'job_title' => $this->string(255)->notNull(),
            'company_name' => $this->string(255)->notNull(),
            'location' => $this->string(255)->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date(),
            'description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk-work_experiences-user_id',
            '{{%work_experiences}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-work_experiences-user_id', '{{%work_experiences}}');
        $this->dropTable('{{%work_experiences}}');
    }
}
