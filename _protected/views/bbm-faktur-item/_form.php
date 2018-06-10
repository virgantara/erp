<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\SalesMasterBarang;
use app\models\SalesStokGudang;

use kartik\depdrop\DepDrop;

$listDataGudang = SalesStokGudang::getListStokGudang();


?>

<div class="bbm-faktur-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'faktur_id')->textInput() ?>

    <?= $form->field($model, 'stok_id')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'stok_id']); ?>

     <?php
     echo $form->field($model, 'barang_id')->widget(DepDrop::classname(), [
        'options'=>['id'=>'barang_id'],
        'pluginOptions'=>[
            'depends'=>['stok_id'],
            'placeholder'=>'..Pilih Barang..',
            'url'=>Url::to(['/sales-stok-gudang/get-barang-stok'])
        ]
    ]);
     ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
