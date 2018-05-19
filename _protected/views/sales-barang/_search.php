<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesBarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_barang') ?>

    <?= $form->field($model, 'nama_barang') ?>

    <?= $form->field($model, 'harga_beli') ?>

    <?= $form->field($model, 'harga_jual') ?>

    <?= $form->field($model, 'id_satuan') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'id_perusahaan') ?>

    <?php // echo $form->field($model, 'id_gudang') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
