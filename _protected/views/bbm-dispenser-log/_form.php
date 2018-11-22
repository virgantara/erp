<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BbmDispenserLog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bbm-dispenser-log-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dispenser_id')->textInput() ?>

    <?= $form->field($model, 'shift_id')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
