<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFaktur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-faktur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_suplier')->textInput() ?>

    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <?= $form->field($model, 'tanggal_faktur')->textInput() ?>

    <?= $form->field($model, 'id_perusahaan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
