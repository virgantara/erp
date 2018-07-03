<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesIncomeSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-income-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_sales') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?= $form->field($model, 'harga') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'id_perusahaan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
