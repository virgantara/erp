<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSubStokSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perusahaan-sub-stok-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'perusahaan_sub_id') ?>

    <?= $form->field($model, 'stok_akhir') ?>

    <?= $form->field($model, 'stok_awal') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'bulan') ?>

    <?php // echo $form->field($model, 'tahun') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'stok_bulan_lalu') ?>

    <?php // echo $form->field($model, 'stok') ?>

    <?php // echo $form->field($model, 'ro_item_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
