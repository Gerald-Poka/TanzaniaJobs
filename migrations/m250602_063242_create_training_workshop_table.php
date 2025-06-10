<?php

use yii\db\Migration;

/**
 * Class m250602_063242_create_training_workshop_table
 */
class m250602_063242_create_training_workshop_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%training_workshops}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string(255)->notNull(),
            'institution' => $this->string(255)->notNull(),
            'location' => $this->string(255)->notNull(),
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date(),
            'description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk-training_workshops-user_id',
            '{{%training_workshops}}',
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
        $this->dropForeignKey('fk-training_workshops-user_id', '{{%training_workshops}}');
        $this->dropTable('{{%training_workshops}}');
    }
}
