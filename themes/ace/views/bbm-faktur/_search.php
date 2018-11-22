<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BbmFakturSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bbm-faktur-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'suplier_id') ?>

    <?= $form->field($model, 'no_lo') ?>

    <?= $form->field($model, 'tanggal_lo') ?>

    <?= $form->field($model, 'no_so') ?>

    <?php // echo $form->field($model, 'tanggal_so') ?>

    <?php // echo $form->field($model, 'perusahaan_id') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
