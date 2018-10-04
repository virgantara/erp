<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Margin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="margin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'batas_bawah')->textInput() ?>

    <?= $form->field($model, 'batas_atas')->textInput() ?>

    <?= $form->field($model, 'persentase')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
