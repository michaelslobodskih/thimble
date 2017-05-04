<?php
$this->title = 'Результаты игры';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Url;

?>


<h3>Результат игры : <?= $model->Status ?> </h3>


<h4>Ваш выбор : <?= $model->chosen_position ?> </h4>
<h4>Настоящее положение шарика : <?= $model->ball_position ?> </h4>
<h4>Вы : <?= $model->Status ?> <?= $model->bid ?> </h4>
<a href="<?= Url::to(['game/create']) ?>">Попробуем еще ?</a>