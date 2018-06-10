<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangLoss */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-loss-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barang_id')->textInput() ?>

    <?= $form->field($model, 'bulan')->textInput() ?>

    <?= $form->field($model, 'tahun')->textInput() ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'jam')->textInput() ?>

    <?= $form->field($model, 'stok_adm')->textInput() ?>

    <?= $form->field($model, 'stok_riil')->textInput() ?>

    <?= $form->field($model, 'loss')->textInput() ?>

    <?= $form->field($model, 'biaya_loss')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
