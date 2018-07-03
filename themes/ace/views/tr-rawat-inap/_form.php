<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tr-rawat-inap-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_rawat')->textInput() ?>

    <?= $form->field($model, 'tanggal_masuk')->textInput() ?>

    <?= $form->field($model, 'jam_masuk')->textInput() ?>

    <?= $form->field($model, 'tanggal_keluar')->textInput() ?>

    <?= $form->field($model, 'jam_keluar')->textInput() ?>

    <?= $form->field($model, 'datetime_masuk')->textInput() ?>

    <?= $form->field($model, 'datetime_keluar')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'pasien_id')->textInput() ?>

    <?= $form->field($model, 'jenis_pasien')->textInput() ?>

    <?= $form->field($model, 'kamar_id')->textInput() ?>

    <?= $form->field($model, 'dokter_id')->textInput() ?>

    <?= $form->field($model, 'biaya_paket_1')->textInput() ?>

    <?= $form->field($model, 'biaya_paket_2')->textInput() ?>

    <?= $form->field($model, 'biaya_paket_3')->textInput() ?>

    <?= $form->field($model, 'status_inap')->textInput() ?>

    <?= $form->field($model, 'status_rawat')->textInput() ?>

    <?= $form->field($model, 'datetime_masuk_ird')->textInput() ?>

    <?= $form->field($model, 'tanggal_masuk_ird')->textInput() ?>

    <?= $form->field($model, 'jam_masuk_ird')->textInput() ?>

    <?= $form->field($model, 'datetime_keluar_ird')->textInput() ?>

    <?= $form->field($model, 'tanggal_keluar_ird')->textInput() ?>

    <?= $form->field($model, 'jam_keluar_ird')->textInput() ?>

    <?= $form->field($model, 'tanggal_pulang')->textInput() ?>

    <?= $form->field($model, 'jam_pulang')->textInput() ?>

    <?= $form->field($model, 'datetime_pulang')->textInput() ?>

    <?= $form->field($model, 'prev_kamar')->textInput() ?>

    <?= $form->field($model, 'next_kamar')->textInput() ?>

    <?= $form->field($model, 'jenis_ird')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status_pasien')->textInput() ?>

    <?= $form->field($model, 'is_naik_kelas')->textInput() ?>

    <?= $form->field($model, 'biaya_total_kamar')->textInput() ?>

    <?= $form->field($model, 'biaya_total_ird')->textInput() ?>

    <?= $form->field($model, 'biaya_dibayar')->textInput() ?>

    <?= $form->field($model, 'biaya_kamar')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
