<?php

namespace app\models;

use Yii;
use app\models\Rating;

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
            [['user_id', 'event_type', 'amount'], 'required'],
            [['user_id', 'amount', 'game_id'], 'integer'],
            [['event_type'], 'string', 'max' => 255],
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


    public function getEventLable()
    {
        switch ($this->event_type) {
            case 'win' :
                return 'выиграли';
                break;
            case 'lose' :
                return 'проиграли';
                break;
            case 'registration' :
                return 'Стартовый балланс';
                break;
            default:
                return 'none';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGame()
    {
        return $this->hasOne(GameHistory::className(), ['id' => 'game_id']);
    }

    public function WinsAmount()
    {
        $user = User::findOne(Yii::$app->user->id);
        $amount = Billing::find()->from('billing')->where(['user_id' => $user->id])->sum('amount');

        return (int)($amount);
    }


}
