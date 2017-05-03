<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GameHistory */
/* @var $form ActiveForm */
?>
<div class="game-create">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'bid')->textInput()->hint('Введите вашу ставку')->label('Ваша ставка'); ?>
    
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- game-create -->
