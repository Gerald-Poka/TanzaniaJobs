<?php

use yii\db\Migration;

/**
 * Class m250602_063221_create_academic_qualification_table
 */
class m250602_063221_create_academic_qualification_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%academic_qualifications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'institution_name' => $this->string(255)->notNull(),
            'degree' => $this->string(255)->notNull(),
            'field_of_study' => $this->string(255)->notNull(),
            'start_year' => $this->integer()->notNull(),
            'end_year' => $this->integer(),
            'grade' => $this->string(50),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key
        $this->addForeignKey(
            'fk-academic_qualifications-user_id',
            '{{%academic_qualifications}}',
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
        $this->dropForeignKey('fk-academic_qualifications-user_id', '{{%academic_qualifications}}');
        $this->dropTable('{{%academic_qualifications}}');
    }
}
