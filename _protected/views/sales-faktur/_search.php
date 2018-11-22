<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFakturSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-faktur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_faktur') ?>

    <?= $form->field($model, 'id_suplier') ?>

    <?= $form->field($model, 'no_faktur') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'tanggal_faktur') ?>

    <?php // echo $form->field($model, 'id_perusahaan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
