<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Рейтинг пользователей';
$this->params['breadcrumbs'][] = $this->title;
$i = 1;
?>

<h3>Рейтинг пользователей в игре</h3>
<ul class="nav nav-tabs">
    <li><a href="<?= Url::to('/game/rating') ?>">Сортировка по сумме выигрыша</a></li>
    <li><a href="<?= Url::to('/game/rating?sort=bywincount') ?>">Сортировка по кол-ву побед</a></li>
</ul>
<table class="table table-hover">
    <thead>
    <tr>
        <th>№</th>
        <th>Пользователь</th>
        <th>Кол-во Игр</th>
        <th>Кол-во Побед</th>
        <th>Заработок</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($model as $item) : ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $item->user->username ?></td>
            <td><?= $item->game_count ?></td>
            <td><?= $item->win_count ?></td>
            <td><?= $item->win_amount ?></td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
<div class="alert alert-success">
    Рейтинг не учитывает аванс при регистрации
</div>