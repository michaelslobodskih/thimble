<?php

use yii\db\Migration;

class m170503_083732_create_table_rating extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%rating}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'user_id' => $this->integer(11)->notNull(),
            'game_count' => $this->integer(11)->notNull(),
            'win_count' => $this->integer(11)->notNull(),
            'win_amount' => $this->integer(11)->notNull(),
        ], $tableOptions);

        $this->addForeignKey('rating_ibfk_1', '{{%rating}}', 'user_id', '{{%user}}', 'id');
    }

    public function safeDown()
    {
        echo "m170503_083732_create_table_rating cannot be reverted.\n";
        return false;
    }
}
