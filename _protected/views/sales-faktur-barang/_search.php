<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFakturBarangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-faktur-barang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_faktur_barang') ?>

    <?= $form->field($model, 'id_faktur') ?>

    <?= $form->field($model, 'id_barang') ?>

    <?= $form->field($model, 'jumlah') ?>

    <?= $form->field($model, 'id_satuan') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
