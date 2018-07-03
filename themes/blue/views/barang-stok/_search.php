<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangStokSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'stok') ?>

    <?= $form->field($model, 'bulan') ?>

    <?= $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'stok_bulan_lalu') ?>

    <?php // echo $form->field($model, 'tebus_liter') ?>

    <?php // echo $form->field($model, 'tebus_rupiah') ?>

    <?php // echo $form->field($model, 'dropping') ?>

    <?php // echo $form->field($model, 'sisa_do') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
