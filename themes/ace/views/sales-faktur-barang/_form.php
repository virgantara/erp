<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SalesMasterBarang;
use app\models\SalesGudang;

use kartik\depdrop\DepDrop;



$listDataBarang=SalesMasterBarang::getListBarangs();

$listDataGudang=SalesGudang::getListGudangs();

?>

<div class="sales-faktur-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_faktur')->textInput() ?>
    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang']); ?>
      <?php
     echo $form->field($model, 'id_barang')->widget(DepDrop::classname(), [
        'options'=>['id'=>'id_barang'],
        'pluginOptions'=>[
            'depends'=>['id_gudang'],
            'placeholder'=>'..Pilih Barang..',
            'url'=>Url::to(['/sales-gudang/get-barang'])
        ]
    ]);
     ?>
    <?= $form->field($model, 'id_satuan')->textInput(); ?>


    <?= $form->field($model, 'jumlah')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
