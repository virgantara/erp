<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PenjualanResep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-resep-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'penjualan_id')->textInput() ?>

    <?= $form->field($model, 'kode_daftar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pasien_id')->textInput() ?>

    <?= $form->field($model, 'dokter_id')->textInput() ?>

    <?= $form->field($model, 'jenis_rawat')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
