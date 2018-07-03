<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-rawat-inap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_rawat_inap') ?>

    <?= $form->field($model, 'kode_rawat') ?>

    <?= $form->field($model, 'tanggal_masuk') ?>

    <?= $form->field($model, 'jam_masuk') ?>

    <?= $form->field($model, 'tanggal_keluar') ?>

    <?php // echo $form->field($model, 'jam_keluar') ?>

    <?php // echo $form->field($model, 'datetime_masuk') ?>

    <?php // echo $form->field($model, 'datetime_keluar') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'pasien_id') ?>

    <?php // echo $form->field($model, 'jenis_pasien') ?>

    <?php // echo $form->field($model, 'kamar_id') ?>

    <?php // echo $form->field($model, 'dokter_id') ?>

    <?php // echo $form->field($model, 'biaya_paket_1') ?>

    <?php // echo $form->field($model, 'biaya_paket_2') ?>

    <?php // echo $form->field($model, 'biaya_paket_3') ?>

    <?php // echo $form->field($model, 'status_inap') ?>

    <?php // echo $form->field($model, 'status_rawat') ?>

    <?php // echo $form->field($model, 'datetime_masuk_ird') ?>

    <?php // echo $form->field($model, 'tanggal_masuk_ird') ?>

    <?php // echo $form->field($model, 'jam_masuk_ird') ?>

    <?php // echo $form->field($model, 'datetime_keluar_ird') ?>

    <?php // echo $form->field($model, 'tanggal_keluar_ird') ?>

    <?php // echo $form->field($model, 'jam_keluar_ird') ?>

    <?php // echo $form->field($model, 'tanggal_pulang') ?>

    <?php // echo $form->field($model, 'jam_pulang') ?>

    <?php // echo $form->field($model, 'datetime_pulang') ?>

    <?php // echo $form->field($model, 'prev_kamar') ?>

    <?php // echo $form->field($model, 'next_kamar') ?>

    <?php // echo $form->field($model, 'jenis_ird') ?>

    <?php // echo $form->field($model, 'status_pasien') ?>

    <?php // echo $form->field($model, 'is_naik_kelas') ?>

    <?php // echo $form->field($model, 'biaya_total_kamar') ?>

    <?php // echo $form->field($model, 'biaya_total_ird') ?>

    <?php // echo $form->field($model, 'biaya_dibayar') ?>

    <?php // echo $form->field($model, 'biaya_kamar') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
