<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="request-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'no_ro') ?>

    <?= $form->field($model, 'petugas1') ?>

    <?= $form->field($model, 'petugas2') ?>

    <?= $form->field($model, 'tanggal_pengajuan') ?>

    <?php // echo $form->field($model, 'tanggal_penyetujuan') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
