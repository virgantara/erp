<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangLossSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-loss-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'bulan') ?>

    <?= $form->field($model, 'tahun') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'jam') ?>

    <?php // echo $form->field($model, 'stok_adm') ?>

    <?php // echo $form->field($model, 'stok_riil') ?>

    <?php // echo $form->field($model, 'loss') ?>

    <?php // echo $form->field($model, 'biaya_loss') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
