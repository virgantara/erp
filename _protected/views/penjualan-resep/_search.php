<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanResepSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-resep-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'penjualan_id') ?>

    <?= $form->field($model, 'kode_daftar') ?>

    <?= $form->field($model, 'pasien_id') ?>

    <?= $form->field($model, 'dokter_id') ?>

    <?php // echo $form->field($model, 'jenis_rawat') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
