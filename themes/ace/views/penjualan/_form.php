<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'barang_id')->textInput() ?>
    <?= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'harga_satuan')->textInput() ?>
    <?= $form->field($model, 'tanggal')->textInput() ?>

   

    <?= $form->field($model, 'qty')->textInput() ?>

   

    <?= $form->field($model, 'harga_total')->textInput() ?>

    
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
