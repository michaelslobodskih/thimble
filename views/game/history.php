<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Billing;
use yii\widgets\LinkPager;

$this->title = 'История игр';
$this->params['breadcrumbs'][] = $this->title;
$total = 0;
?>
<ul class="nav nav-tabs">
    <li><a href="<?= Url::to('/game/history') ?>">История игр</a></li>
    <li><a href="<?= Url::to('/game/billing') ?>">История расчетов</a></li>

</ul>

<h3>История ваших игр</h3>
<table class="table table-hover">
    <thead>
    <tr>
        <th>Дата</th>
        <th>Ставка</th>
        <th>Ваш выбор</th>
        <th>Правильный выбор</th>
        <th>Итог</th>
    </tr>
    </thead>
    <tbody>

    <? foreach ($model as $item) : ?>

        <tr>
            <td><?= date("d.m.Y H:i", $item->game_ended) ?></td>
            <td><?= $item->bid ?></td>
            <td><?= $item->chosen_position ?></td>
            <td><?= $item->ball_position ?></td>
            <td>
                <span class="label label-<?= $item->status > 'lose' ? 'success' : 'danger' ?>"><?= $item->status == "win" ? $item->bid : (0 - $item->bid) ?></span>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<div class="text-center">
    <?
    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
    ?>
</div>
<div class="alert alert-success">
    Итого Ваш выигрыш (c учетом аванса при регистрации) : <strong><?= Billing::winsamount() ?></strong>
</div>

