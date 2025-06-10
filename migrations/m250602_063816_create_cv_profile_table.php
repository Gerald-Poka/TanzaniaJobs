<?php

use yii\db\Migration;

/**
 * Class m250602_063816_create_cv_profile_table
 */
class m250602_063816_create_cv_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cv_profiles}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'profile_picture' => $this->string(255),
            'summary' => $this->text(),
            'skills' => $this->text(),
            'languages' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk-cv_profiles-user_id',
            '{{%cv_profiles}}',
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
        $this->dropForeignKey('fk-cv_profiles-user_id', '{{%cv_profiles}}');
        $this->dropTable('{{%cv_profiles}}');
    }
}
