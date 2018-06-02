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

    <?= $form->field($model, 'dropping')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
