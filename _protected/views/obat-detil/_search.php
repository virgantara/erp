<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ObatDetilSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="obat-detil-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'nama_generik') ?>

    <?= $form->field($model, 'kekuatan') ?>

    <?= $form->field($model, 'satuan_kekuatan') ?>

    <?php // echo $form->field($model, 'jns_sediaan') ?>

    <?php // echo $form->field($model, 'b_i_r') ?>

    <?php // echo $form->field($model, 'gen_non') ?>

    <?php // echo $form->field($model, 'nar_p_non') ?>

    <?php // echo $form->field($model, 'oakrl') ?>

    <?php // echo $form->field($model, 'kronis') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
