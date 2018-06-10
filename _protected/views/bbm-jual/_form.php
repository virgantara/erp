<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use kartik\depdrop\DepDrop;

use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\BbmJual */
/* @var $form yii\widgets\ActiveForm */

use app\models\BbmDispenser;
use app\models\SalesMasterBarang;
use app\models\Shift;
use app\models\Perusahaan;

$listDataBarang=SalesMasterBarang::getListBarangs();
$listDataShift=Shift::getListShifts();

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;   
}

$model->tanggal = $model->isNewRecord ? date('d-m-Y') : $model->tanggal;

$listData=Perusahaan::getListPerusahaans();

$listDispenser = BbmDispenser::getListDispensers();
?>

<div class="bbm-jual-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
      <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
     <?= $form->field($model, 'barang_id')->dropDownList($listDataBarang, ['prompt'=>'.. Pilih BBM','id'=>'barang_id']); ?>
     <?php
     echo $form->field($model, 'dispenser_id')->widget(DepDrop::classname(), [
        'options'=>['id'=>'dispenser_id'],
        'pluginOptions'=>[
            'depends'=>['barang_id'],
            'placeholder'=>'..Pilih Dispenser..',
            'url'=>Url::to(['/sales-master-barang/get-dispenser'])
        ]
    ]);
     ?>
    <?= $form->field($model, 'shift_id')->dropDownList($listDataShift, ['prompt'=>'.. Pilih Shift']); ?>
     <?= $form->field($model, 'stok_akhir')->textInput() ?>
    <?= $form->field($model, 'stok_awal')->textInput() ?>

    
    
      <?= $form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
