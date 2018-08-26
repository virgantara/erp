<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObatDetil */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obat-detil-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barang_id')->textInput() ?>

    <?= $form->field($model, 'nama_generik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kekuatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'satuan_kekuatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jns_sediaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'b_i_r')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gen_non')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nar_p_non')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oakrl')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kronis')->dropDownList([ '-' => '-', 'Non Kronis' => 'Non Kronis', 'Kronis' => 'Kronis', '' => '', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
