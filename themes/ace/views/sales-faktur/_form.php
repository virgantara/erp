<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use yii\helpers\ArrayHelper;
use app\models\Perusahaan;
use app\models\SalesSuplier;
use kartik\date\DatePicker;



$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->id_perusahaan = $userPt;

}

$listData=Perusahaan::getListPerusahaans();
$listDataSupp=SalesSuplier::getListSupliers();

?>

<div class="sales-faktur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_suplier')->dropDownList($listDataSupp, ['prompt'=>'..Pilih Suplier..','id'=>'id_suplier']);?>

    <?= $form->field($model, 'no_faktur')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'tanggal_faktur')->widget(
        DatePicker::className(),[
            // 'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?= $form->field($model, 'tanggal_jatuh_tempo')->widget(
        DatePicker::className(),[
            // 'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?= $form->field($model, 'tanggal_dropping')->widget(
        DatePicker::className(),[
            // 'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?= $form->field($model, 'id_perusahaan')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
