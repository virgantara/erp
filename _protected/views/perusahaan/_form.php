<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\PerusahaanLevel;
use app\models\PerusahaanJenis;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Perusahaan */
/* @var $form yii\widgets\ActiveForm */

$list=PerusahaanLevel::find()->all();
$listData=ArrayHelper::map($list,'level','nama');

$list=PerusahaanJenis::find()->all();
$listJenis=ArrayHelper::map($list,'id','nama');


?>

<div class="perusahaan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'level')->dropDownList($listData, ['prompt'=>'..Pilih Level..']) ?>
    
    <?= $form->field($model, 'jenis')->dropDownList($listJenis, ['prompt'=>'..Pilih Jenis..']) ?>

    


    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
