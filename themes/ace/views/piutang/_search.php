<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PiutangSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="piutang-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kwitansi') ?>

    <?= $form->field($model, 'penanggung_jawab') ?>

    <?= $form->field($model, 'perkiraan_id') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'tanggal') ?>

    <?php // echo $form->field($model, 'qty') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'kode_transaksi') ?>

    <?php // echo $form->field($model, 'customer_id') ?>

    <?php // echo $form->field($model, 'no_nota') ?>

    <?php // echo $form->field($model, 'is_lunas') ?>

    <?php // echo $form->field($model, 'barang_id') ?>

    <?php // echo $form->field($model, 'rupiah') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
