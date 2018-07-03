<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangStok */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-stok-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'barang_id')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>

    <?= $form->field($model, 'bulan')->textInput() ?>

    <?= $form->field($model, 'tahun')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'stok_bulan_lalu')->textInput() ?>

    <?= $form->field($model, 'tebus_liter')->textInput() ?>

    <?= $form->field($model, 'tebus_rupiah')->textInput() ?>

    <?= $form->field($model, 'dropping')->textInput() ?>

    <?= $form->field($model, 'sisa_do')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'sisa_do_lalu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
