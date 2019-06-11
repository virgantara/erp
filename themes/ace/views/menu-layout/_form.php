<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MenuLayout */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-layout-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent')->dropDownList(\yii\helpers\ArrayHelper::map($listParent,'id',function($data){return !empty($data->parent0) ? $data->parent0->nama.' > '.$data->nama : $data->nama;}), ['prompt'=>'..Pilih Parent..']) ?>
   
    <?= $form->field($model, 'urutan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
