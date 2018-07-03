<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\APasienSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apasien-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'NoMedrec') ?>

    <?= $form->field($model, 'NAMA') ?>

    <?= $form->field($model, 'ALAMAT') ?>

    <?= $form->field($model, 'KodeKec') ?>

    <?= $form->field($model, 'TMPLAHIR') ?>

    <?php // echo $form->field($model, 'TGLLAHIR') ?>

    <?php // echo $form->field($model, 'PEKERJAAN') ?>

    <?php // echo $form->field($model, 'AGAMA') ?>

    <?php // echo $form->field($model, 'JENSKEL') ?>

    <?php // echo $form->field($model, 'GOLDARAH') ?>

    <?php // echo $form->field($model, 'TELP') ?>

    <?php // echo $form->field($model, 'JENISIDENTITAS') ?>

    <?php // echo $form->field($model, 'NOIDENTITAS') ?>

    <?php // echo $form->field($model, 'STATUSPERKAWINAN') ?>

    <?php // echo $form->field($model, 'BeratLahir') ?>

    <?php // echo $form->field($model, 'Desa') ?>

    <?php // echo $form->field($model, 'KodeGol') ?>

    <?php // echo $form->field($model, 'TglInput') ?>

    <?php // echo $form->field($model, 'JamInput') ?>

    <?php // echo $form->field($model, 'AlmIp') ?>

    <?php // echo $form->field($model, 'NoMedrecLama') ?>

    <?php // echo $form->field($model, 'NoKpst') ?>

    <?php // echo $form->field($model, 'KodePisa') ?>

    <?php // echo $form->field($model, 'KdPPK') ?>

    <?php // echo $form->field($model, 'NamaOrtu') ?>

    <?php // echo $form->field($model, 'NamaSuamiIstri') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
