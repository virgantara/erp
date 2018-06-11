<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Piutang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="piutang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kwitansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penanggung_jawab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perkiraan_id')->textInput() ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tanggal')->textInput() ?>

    <?= $form->field($model, 'nilai')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'perusahaan_id')->textInput() ?>

    <?= $form->field($model, 'kode_transaksi')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
