<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\models\SalesMasterBarang;

use kartik\date\DatePicker;
$listDataBarang=SalesMasterBarang::getListBarangs();


?>

<div class="bbm-faktur-item-form">

    <?php $form = ActiveForm::begin(); ?>
  
    <?= $form->field($model, 'barang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-3']])->dropDownList($listDataBarang); ?>
    
    <?= $form->field($model, 'jumlah',['options'=>['class'=>'form-group col-xs-12 col-lg-3']])->textInput(['type'=>'number']) ?>
    <?= $form->field($model, 'harga',['options'=>['class'=>'form-group col-xs-12 col-lg-3']])->textInput() ?>
    <?= $form->field($model, 'pph',['options'=>['class'=>'form-group col-xs-12 col-lg-3']])->textInput() ?>
    
    <?= $form->field($model, 'faktur_id',['options'=>['class'=>'form-group col-xs-12 ']])->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
