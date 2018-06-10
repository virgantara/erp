<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangRekap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-rekap-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tebus_liter')->textInput() ?>

    <?= $form->field($model, 'tebus_rupiah')->textInput() ?>

    <?= $form->field($model, 'dropping')->textInput() ?>

    <?= $form->field($model, 'sisa_do')->textInput() ?>

    <?= $form->field($model, 'jual_liter')->textInput() ?>

    <?= $form->field($model, 'jual_rupiah')->textInput() ?>

    <?= $form->field($model, 'stok_adm')->textInput() ?>

    <?= $form->field($model, 'stok_riil')->textInput() ?>

    <?= $form->field($model, 'loss')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'barang_id')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
