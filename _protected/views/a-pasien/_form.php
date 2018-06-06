<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\APasien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apasien-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'NAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KodeKec')->textInput() ?>

    <?= $form->field($model, 'TMPLAHIR')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TGLLAHIR')->textInput() ?>

    <?= $form->field($model, 'PEKERJAAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'AGAMA')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENSKEL')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'GOLDARAH')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'TELP')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'JENISIDENTITAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NOIDENTITAS')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'STATUSPERKAWINAN')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'BeratLahir')->textInput() ?>

    <?= $form->field($model, 'Desa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KodeGol')->textInput() ?>

    <?= $form->field($model, 'TglInput')->textInput() ?>

    <?= $form->field($model, 'JamInput')->textInput() ?>

    <?= $form->field($model, 'AlmIp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NoMedrecLama')->textInput() ?>

    <?= $form->field($model, 'NoKpst')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'KodePisa')->textInput() ?>

    <?= $form->field($model, 'KdPPK')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NamaOrtu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'NamaSuamiIstri')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
