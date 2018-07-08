<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrderIn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-order-in-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <?= $form->field($model, 'departemen_id')->textInput() ?>

    <?= $form->field($model, 'ro_id')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
