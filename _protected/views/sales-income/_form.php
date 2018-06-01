<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


use app\models\SalesBarang;
use app\models\SalesGudang;

use kartik\date\DatePicker;

use kartik\depdrop\DepDrop;


/* @var $this yii\web\View */
/* @var $model app\models\SalesIncome */
/* @var $form yii\widgets\ActiveForm */

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->id_perusahaan = $userPt;

}

$listData=SalesGudang::getListGudangs();

?>

<div class="sales-income-form">

    <?php $form = ActiveForm::begin(); ?>
      <?php
      echo $form->field($model, 'id_perusahaan')->hiddenInput()->label(false);

    echo $form->field($model, 'id_gudang')->dropDownList($listData, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang']);

   
     ?>


     <?php
     echo $form->field($model, 'stok_id')->widget(DepDrop::classname(), [
        'options'=>['id'=>'stok_id'],
        'pluginOptions'=>[
            'depends'=>['id_gudang'],
            'placeholder'=>'..Pilih Barang..',
            'url'=>Url::to(['/sales-stok-gudang/get-barang'])
        ]
    ]);
     ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>


    <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
