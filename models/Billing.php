<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "billing".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $event_type
 * @property integer $amount
 * @property integer $game_id
 *
 * @property User $user
 * @property GameHistory $gameHistory
 */
class Billing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'billing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'event_type', 'amount'], 'required'],
            [['id', 'user_id', 'amount', 'game_id'], 'integer'],
            [['event_type'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'ID пользователя',
            'event_type' => 'Тип события',
            'amount' => 'Сумма',
            'game_id' => 'Ссылка на игру',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGameHistory()
    {
        return $this->hasOne(GameHistory::className(), ['id' => 'game_id']);
    }
}
