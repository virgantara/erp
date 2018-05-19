<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Perusahaan;
use app\models\SatuanBarang;
use app\models\SalesGudang;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\SalesBarang */
/* @var $form yii\widgets\ActiveForm */

$list=Perusahaan::find()->where(['jenis' => '3'])->all();
$listData=ArrayHelper::map($list,'id_perusahaan','nama');

$list=SatuanBarang::find()->where(['jenis' => '3'])->all();
$listSatuan=ArrayHelper::map($list,'id_satuan','nama');

// $list=SalesGudang::find()->where(['jenis' => '3'])->all();
// $listSatuan=ArrayHelper::map($list,'id_satuan','nama');


?>

<div class="sales-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>

  
    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    <?php
    echo $form->field($model, 'id_perusahaan')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);

     ?>

    <?php
     echo $form->field($model, 'id_gudang')->widget(DepDrop::classname(), [
        'options'=>['id'=>'id_gudang'],
        'pluginOptions'=>[
            'depends'=>['id_perusahaan'],
            'placeholder'=>'..Pilih Gudang..',
            'url'=>Url::to(['/perusahaan/get-gudang'])
        ]
    ]);
     ?>

      <?php 
       echo $form->field($model, 'id_satuan')->widget(DepDrop::classname(), [
        'options'=>['id'=>'id_satuan'],
        'pluginOptions'=>[
            'depends'=>['id_perusahaan'],
            'placeholder'=>'..Pilih Satuan..',
            'url'=>Url::to(['/perusahaan/get-satuan'])
        ]
    ]);
    

      ?> 
        <?= $form->field($model, 'jumlah')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
