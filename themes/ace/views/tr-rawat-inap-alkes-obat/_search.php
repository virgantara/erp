<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInapAlkesObatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-rawat-inap-alkes-obat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_rawat_inap') ?>

    <?= $form->field($model, 'kode_alkes') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'nilai') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'id_m_obat_akhp') ?>

    <?php // echo $form->field($model, 'tanggal_input') ?>

    <?php // echo $form->field($model, 'id_dokter') ?>

    <?php // echo $form->field($model, 'jumlah') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
