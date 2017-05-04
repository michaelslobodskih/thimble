<?php

namespace app\models;

use Yii;
use app\models\Billing;
use app\models\Rating;

/**
 * This is the model class for table "rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $game_count
 * @property integer $win_count
 * @property integer $win_amount
 *
 * @property User $user
 */
class Rating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'game_count', 'win_count', 'win_amount'], 'required'],
            [['user_id', 'game_count', 'win_count', 'win_amount'], 'integer'],
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
            'user_id' => 'User ID',
            'game_count' => 'Game Count',
            'win_count' => 'Win Count',
            'win_amount' => 'Win Amount',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function UpdateRating()
    {
        $user = User::findOne(Yii::$app->user->id);
        if ($user) {
            //Ищем есть ли запись об этом пользователе в рейтингах
            $rating = Rating::find()->where(['user_id' => $user->id])->one();
            if (!$rating) {
                //Нет записи, создадим
                $rating = new Rating;
                $rating->user_id = $user->id;
                $rating->save();
            }

            $rating->game_count = GameHistory::find()->from('game_history')->where(['user_id' => $user->id])->count();
            $rating->win_count = Billing::find()->from('billing')->where(['user_id' => $user->id, 'event_type' => 'win'])->count();
            $rating->win_amount = Billing::find()->from('billing')->where(['user_id' => $user->id, 'event_type' => 'win'])->sum('amount');
            $rating->save();
        }
    }
}
