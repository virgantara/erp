<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BbmJualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bbm-jual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tanggal') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'created') ?>

    <?= $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'shift_id') ?>

    <?php // echo $form->field($model, 'dispenser_id') ?>

    <?php // echo $form->field($model, 'stok_awal') ?>

    <?php // echo $form->field($model, 'stok_akhir') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
