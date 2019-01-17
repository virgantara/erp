<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CartSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cart-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kode_transaksi') ?>

    <?= $form->field($model, 'kode_racikan') ?>

    <?= $form->field($model, 'departemen_stok_id') ?>

    <?= $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'kekuatan') ?>

    <?php // echo $form->field($model, 'dosis_minta') ?>

    <?php // echo $form->field($model, 'subtotal') ?>

    <?php // echo $form->field($model, 'jumlah_ke_apotik') ?>

    <?php // echo $form->field($model, 'jumlah_hari') ?>

    <?php // echo $form->field($model, 'signa1') ?>

    <?php // echo $form->field($model, 'signa2') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
