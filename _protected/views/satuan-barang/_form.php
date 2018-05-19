<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;


use app\models\PerusahaanJenis;

/* @var $this yii\web\View */
/* @var $model app\models\SatuanBarang */
/* @var $form yii\widgets\ActiveForm */


$list=PerusahaanJenis::find()->all();
$listJenis=ArrayHelper::map($list,'id','nama');
?>

<div class="satuan-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
 
    <?= $form->field($model, 'jenis')->dropDownList($listJenis, ['prompt'=>'..Pilih Jenis..']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
