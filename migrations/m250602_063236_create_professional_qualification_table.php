<?php

use yii\db\Migration;

/**
 * Class m250602_063236_create_professional_qualification_table
 */
class m250602_063236_create_professional_qualification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%professional_qualifications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'certificate_name' => $this->string(255)->notNull(),
            'organization' => $this->string(255)->notNull(),
            'issued_date' => $this->date()->notNull(),
            'description' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk-professional_qualifications-user_id',
            '{{%professional_qualifications}}',
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
        $this->dropForeignKey('fk-professional_qualifications-user_id', '{{%professional_qualifications}}');
        $this->dropTable('{{%professional_qualifications}}');
    }
}
