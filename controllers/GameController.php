<?php

namespace app\controllers;

use app\models\GameHistory;
use app\models\Billing;
use app\models\Rating;
use app\models\User;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii;

class GameController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GameHistory;

        //Проверяем отправил ли пользователь ставку через POST запрос
        if ($request->isPost && $request->post('GameHistory')['bid'] > 0) {
            //Проверяем что баланс пользователя больше чем ставка (сверяем с полем ballance таблицы user)
            if (User::findOne(Yii::$app->user->id)->ballance >= $request->post('GameHistory')['bid']) {
                //Записываем информацию о том что пользователь сделал ставку и генерируем позицию шарика
                $model->user_id = Yii::$app->user->id;
                $model->game_started = time();
                $model->ball_position = rand(1, 3);
                $model->bid = $request->post('GameHistory')['bid'];
                if ($model->save()) {
                    //Показываем пользователю вьюшку с тремя наперстками
                    return $this->render('play', ['model' => $model]);
                } else {
                    return $this->redirect(["site/error"]);
                }
            } else {
                Yii::$app->getSession()->setFlash('danger', 'На вашем счете недостаточно средств для игры с такой ставкой.');
                return $this->render('create', ['model' => $model]);
            }
        } else {
            //Показываем форму для выбора ставки
            return $this->render('create', ['model' => $model]);
        }
    }


    public function actionMakechoose()
    {
        $request = Yii::$app->request;

        $model = GameHistory::findOne($request->get('game'));
        if ($model) {
            if ($model->game_ended > 0) {
                throw new \yii\web\NotFoundHttpException('Игра уже состоялась, результаты можно посмотреть в истории');
            }

            if ($model->user_id == Yii::$app->user->id) {
                //Сохраняем информацию в таблицу о транзакциях
                $billing = new Billing;
                $billing->user_id = Yii::$app->user->id;
                $billing->event_date = time();
                $billing->game_id = $model->id;

                //Сохраняем остальную информацию о игре
                $model->game_ended = time();
                $model->chosen_position = $request->get('select');
                if ($model->chosen_position == $model->ball_position) {
                    $billing->event_type = 'win';
                    $model->status = 'win';
                    $billing->amount = $model->bid;
                } else {
                    $model->status = 'lose';
                    $billing->event_type = 'lose';
                    $billing->amount = 0 - $model->bid;
                }


                if ($model->save() && $billing->save()) {
                    //Обновляем баланс текущего пользователя (храним в таблице user поле ballance)
                    User::UpdateBalanceInProfile();

                    //Обновляем рейтинг для текущего пользователя
                    Rating::UpdateRating();

                    return $this->render('info', ['model' => $model]);
                } else {
                    throw new \yii\web\NotFoundHttpException('Ошибка');
                }
            } else {
                throw new \yii\web\NotFoundHttpException('Это не ваша игра');
            }
        } else {
            throw new \yii\web\NotFoundHttpException('Нет такой игры');
        }
    }

    public function actionRating()
    {
        $request = Yii::$app->request;

        if ($request->get('sort') == "bywincount") {
            $sort = 'win_count DESC';
        } else {
            $sort = 'win_amount DESC';
        }

        //постраничный вывод
        $pagination = new Pagination(['pageSize' => 20 ,'totalCount' => Rating::find()->count()]);

        //Получаем данные о рейтинге из таблицы ratings
        $model  = Rating::find()->with('user')->orderBy($sort)->offset($pagination->offset)->limit($pagination->limit)->all();

        return $this->render('rating', ['model' => $model,'pagination'=>$pagination]);
    }

    public function actionHistory()
    {
        //постраничный вывод
        $pagination = new Pagination(['pageSize' => 20 ,'totalCount' => GameHistory::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['not', ['game_ended' => null]])->count()]);

        //Получаем все данные о играх текущего пользователя
        $model = GameHistory::find()->where(['user_id' => Yii::$app->user->id])->andWhere(['not', ['game_ended' => null]])->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('history', ['model' => $model,'pagination'=>$pagination]);
    }

    public function actionBilling()
    {
        //постраничный вывод
        $pagination = new Pagination(['pageSize' => 20 ,'totalCount' => Billing::find()->where(['user_id' => Yii::$app->user->id])->count()]);


        //Получаем данные из таблицы billing
        $model = Billing::find()->with('user', 'game')->where(['user_id' => Yii::$app->user->id])->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('billing', ['model' => $model,'pagination'=>$pagination]);
    }


}
