<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangRekapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-rekap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tebus_liter') ?>

    <?= $form->field($model, 'tebus_rupiah') ?>

    <?= $form->field($model, 'dropping') ?>

    <?= $form->field($model, 'sisa_do') ?>

    <?php // echo $form->field($model, 'jual_liter') ?>

    <?php // echo $form->field($model, 'jual_rupiah') ?>

    <?php // echo $form->field($model, 'stok_adm') ?>

    <?php // echo $form->field($model, 'stok_riil') ?>

    <?php // echo $form->field($model, 'loss') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'barang_id') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
