<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Billing;

/**
 * Signup form
 */
class RegisterForm extends Model
{

    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->ballance = Yii::$app->params['BalanceAfterRegistration'];

        if ($user->save()) {
            $billing = new Billing;
            $billing->user_id = $user->id;
            $billing->event_type = "registration";
            $billing->event_date = time();
            $billing->amount = 100;
            $billing->save();

            return $user;
        } else {
            return null;
        }
    }
}
