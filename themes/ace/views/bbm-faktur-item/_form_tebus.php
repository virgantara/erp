<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\SalesMasterBarang;
use app\models\SalesStokGudang;

use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;

$listDataGudang = SalesStokGudang::getListStokGudang();


?>

<div class="bbm-faktur-item-form">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'nomor_lo',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'tanggal_lo',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            // 'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal LO ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    
    <?= $form->field($model, 'stok_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'stok_id']); ?>

     <?php
     echo $form->field($model, 'barang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(DepDrop::classname(), [
        'options'=>['id'=>'barang_id'],
        'pluginOptions'=>[
            'depends'=>['stok_id'],
            'placeholder'=>'..Pilih Barang..',
            'url'=>Url::to(['/sales-stok-gudang/get-barang-stok'])
        ]
    ]);
     ?>

    <?= $form->field($model, 'jumlah',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput(['type'=>'number']) ?>
    <?= $form->field($model, 'harga',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput() ?>
    
    <?= $form->field($model, 'faktur_id',['options'=>['class'=>'form-group col-xs-12 ']])->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
