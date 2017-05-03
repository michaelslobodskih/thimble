<?php

use yii\db\Migration;

class m170503_083725_create_table_game_history extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%game_history}}', [
            'id' => $this->integer(11)->notNull()->append('AUTO_INCREMENT PRIMARY KEY'),
            'user_id' => $this->integer(11)->notNull()->comment('ID пользователя'),
            'game_started' => $this->integer(11)->comment('Время начала игры'),
            'game_ended' => $this->integer(11)->comment('Время окончания игры'),
            'ball_position' => $this->integer(11)->comment('Правильная позиция шарика'),
            'chosen_position' => $this->integer(11)->comment('Выбранная позиция пользователем'),
            'status' => $this->string()->comment('Победа или Проигрыш'),
            'bid' => $this->integer(11)->notNull()->comment('Ставка'),
        ], $tableOptions);

        //$this->addForeignKey('game_history_ibfk_2', '{{%game_history}}', 'id', '{{%billing}}', 'game_id');
        $this->addForeignKey('game_history_ibfk_1', '{{%game_history}}', 'user_id', '{{%user}}', 'id');
    }

    public function safeDown()
    {
        echo "m170503_083725_create_table_game_history cannot be reverted.\n";
        return false;
    }
}
