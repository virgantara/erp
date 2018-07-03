<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Perusahaan;
use app\models\SalesSuplier;
use kartik\date\DatePicker;


$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;   
}


$listData=Perusahaan::getListPerusahaans();
$listDataSupp=SalesSuplier::getListSupliers();

// $model->tanggal_lo = $model->isNewRecord || ! ? date('d-m-Y') : $model->tanggal_lo;
$model->tanggal_so = $model->isNewRecord ? date('d-m-Y') : $model->tanggal_so;

?>

<div class="bbm-faktur-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'no_so')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_so')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            // 'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal SO ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?= $form->field($model, 'no_lo')->textInput(['maxlength' => true]) ?>

     <?= $form->field($model, 'tanggal_lo')->widget(
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

    
     <?= $form->field($model, 'suplier_id')->dropDownList($listDataSupp, ['prompt'=>'..Pilih Suplier..']);?>
    <?= $form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
