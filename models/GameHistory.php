<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "game_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $game_started
 * @property integer $game_ended
 * @property integer $ball_position
 * @property integer $chosen_position
 * @property string $status
 * @property integer $bid
 *
 * @property User $user
 */
class GameHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'game_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'bid'], 'required'],
            [['user_id', 'game_started', 'game_ended', 'ball_position', 'chosen_position', 'bid'], 'integer'],
            ['bid', 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['status'], 'string', 'max' => 255],
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
            'game_started' => 'Время начала игры',
            'game_ended' => 'Время окончания игры',
            'ball_position' => 'Правильная позиция шарика',
            'chosen_position' => 'Выбранная позиция пользователем',
            'status' => 'Победа или Проигрыш',
            'bid' => 'Ставка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getStatus()
    {
        if ($this->status == 'win') return 'выиграли';
        if ($this->status == 'lose') return 'проиграли';
        return 'игра не закончена';
    }
}
