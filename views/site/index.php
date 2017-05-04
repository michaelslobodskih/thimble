<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Игра наперсток!</h1>

        <p class="lead">Добро пожаловать в онлайн игру "наперсток"</p>
    </div>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Шаг 1</h2>
                <p>Прочитайте правила игры</p>
                <p><a class="btn btn-default" href="<?= Url::to('site/about') ?>">Описание</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Шаг 2</h2>
                <p>Загеристрируйтесь в системе и получите стартовый баланс в 100 условных единиц</p>
                <p><a class="btn btn-default" href="<?= Url::to('site/register') ?>">Регистрация</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Шаг 3</h2>
                <p>Играйте и выигрывайте</p>
                <p><a class="btn btn-default" href="<?= Url::to('game/create') ?>">Начать игру</a></p>
            </div>
        </div>
    </div>
</div>
