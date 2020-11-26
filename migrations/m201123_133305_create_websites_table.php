<?php

use yii\db\Migration;
use Carbon\Carbon;

/**
 * Handles the creation of table `{{%websites}}`.
 */
class m201123_133305_create_websites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%websites_checker}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->defaultValue(1),
            'name' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'email_sended_at' => $this->datetime(),
            'created_at' => $this->datetime()->defaultValue(date('c')),
            'updated_at' => $this->datetime()->defaultValue(date('c')),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%websites}}');
    }
}
