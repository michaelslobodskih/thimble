<?php
$this->title = 'Выберите наперсток';
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Url;

?>

<h3>Ваша ставка : <?= $model->bid ?></h3>

<h3>Выберите наперсток</h3>

<a href="<?= Url::to(['game/makechoose', 'game' => $model->id, 'select' => 1]) ?>"><img src="/images/n.jpg"></a>
<a href="<?= Url::to(['game/makechoose', 'game' => $model->id, 'select' => 2]) ?>"><img src="/images/n.jpg"></a>
<a href="<?= Url::to(['game/makechoose', 'game' => $model->id, 'select' => 3]) ?>"><img src="/images/n.jpg"></a>