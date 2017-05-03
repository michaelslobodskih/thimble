<?php

namespace app\controllers;
use app\models\GameHistory;
class GameController extends \yii\web\Controller
{
    public function actionCreate()
    {
	$model = new GameHistory;
	
        return $this->render('create',['model'=>$model]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

}
