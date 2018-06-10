<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
use kartik\time\TimePicker;
use kartik\depdrop\DepDrop;

$listDataBarang=\app\models\SalesMasterBarang::getListBarangs();
$listDataShift=\app\models\Shift::getListShifts();

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;   
}

$model->tanggal = $model->isNewRecord ? date('d-m-Y') : $model->tanggal;
$model->jam = $model->isNewRecord ? date('H:i:s') : $model->jam;

$listData=\app\models\Perusahaan::getListPerusahaans();
?>

<div class="barang-stok-opname-form">

    <?php $form = ActiveForm::begin(); ?>
     <?= $form->field($model, 'tanggal',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(
        DatePicker::className(),[
           
            'size' => 'lg',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Pilih Tanggal Ukur ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>

     <?= $form->field($model, 'jam',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(
        TimePicker::className(),[
           'options' => ['placeholder' => 'Select start operating time ...'],
        'size' => 'lg',
        'pluginOptions' => [
            'showSeconds' => true,
            'secondStep' => 10, 
            'showMeridian' => false,
            'minuteStep' => 5,
            
        ]
        ]
    ) ?>
   
    <?= $form->field($model, 'barang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataBarang, ['prompt'=>'.. Pilih BBM']); ?>   

    <?php
     echo $form->field($model, 'gudang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(DepDrop::classname(), [
        'options'=>['id'=>'gudang_id'],
        'pluginOptions'=>[
            'depends'=>['barangstokopname-barang_id'],
            'placeholder'=>'..Pilih Gudang..',
            'url'=>\yii\helpers\Url::to(['/sales-stok-gudang/get-gudang-by-barang'])
        ]
    ]);
     ?>
 <?= $form->field($model, 'shift_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataShift, ['prompt'=>'.. Pilih Shift']); ?>

    <?= $form->field($model, 'stok',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput() ?>

     <?= $form->field($model, 'perusahaan_id',['options'=>['class'=>'form-group col-xs-12 col-lg-12']])->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
