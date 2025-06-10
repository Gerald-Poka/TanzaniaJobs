<?php

use yii\db\Migration;

/**
 * Class m250529_135946_update_user_table
 */
class m250529_135946_update_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Check if table exists and create/modify as needed
        $tableExists = $this->db->schema->getTableSchema('{{%user}}') !== null;

        if (!$tableExists) {
            $this->createTable('{{%user}}', [
                'id' => $this->primaryKey(),
                'firstname' => $this->string()->notNull(),
                'lastname' => $this->string()->notNull(),
                'email' => $this->string()->notNull()->unique(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string()->unique(),
                'auth_key' => $this->string(32)->notNull(),
                'access_token' => $this->string()->unique(),
                'role' => $this->integer()->notNull()->defaultValue(1),
                'status' => $this->integer()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]);
        } else {
            // Add missing columns if they don't exist
            $columns = $this->db->schema->getTableSchema('{{%user}}')->columnNames;

            if (!in_array('password_reset_token', $columns)) {
                $this->addColumn('{{%user}}', 'password_reset_token', $this->string()->unique());
            }
            if (!in_array('access_token', $columns)) {
                $this->addColumn('{{%user}}', 'access_token', $this->string()->unique());
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250529_135946_update_user_table cannot be reverted.\n";

        return false;
    }
    */
}
