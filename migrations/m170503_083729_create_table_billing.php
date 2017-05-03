<?php

use yii\db\Migration;

class m170503_083729_create_table_billing extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%billing}}', [
            'id' => $this->integer(11)->notNull(),
            'user_id' => $this->integer(11)->notNull()->comment('ID пользователя'),
            'event_type' => $this->string()->notNull()->comment('Тип события'),
            'amount' => $this->integer(11)->notNull()->comment('Сумма'),
            'game_id' => $this->integer(11)->comment('Ссылка на игру'),
        ], $tableOptions);

        $this->addForeignKey('billing_ibfk_1', '{{%billing}}', 'user_id', '{{%user}}', 'id');
    }

    public function safeDown()
    {
        echo "m170503_083729_create_table_billing cannot be reverted.\n";
        return false;
    }
}
