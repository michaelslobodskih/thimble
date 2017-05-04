<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Billing;

$this->title = 'История игр';
$this->params['breadcrumbs'][] = $this->title;
$total = 0;
?>
<ul class="nav nav-tabs">
    <li><a href="<?= Url::to('/game/history') ?>">История игр</a></li>
    <li><a href="<?= Url::to('/game/billing') ?>">История расчетов</a></li>
</ul>

<h3>История расчетов</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Дата</th>
        <th>Событие</th>
        <th>Ставка</th>
        <th>Ваш выбор</th>
        <th>Правильный выбор</th>
        <th>Итог</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($model as $item) : ?>
        <tr>
            <td><?= date("d.m.Y H:i", $item->event_date) ?></td>
            <td><?= $item->EventLable ?></td>
            <td><?= $item->amount ?></td>
            <td><?= $item->game ? $item->game->chosen_position : '' ?></td>
            <td><?= $item->game ? $item->game->ball_position : '' ?></td>
            <td>
                <span class="label label-<?= $item->amount > 0 ? 'success' : 'danger' ?>"><?= $item->amount ?></span>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>

<div class="alert alert-success">
    Итого Ваш выигрыш (c учетом аванса при регистрации) : <strong><?= Billing::winsamount() ?></strong>
</div>