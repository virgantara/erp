<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use app\models\Perusahaan;
use app\models\Departemen;

use kartik\date\DatePicker;


$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;   
}


$listData=Perusahaan::getListPerusahaans();
$listDataDept=Departemen::getListDepartemens();

?>

<div class="request-order-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'tanggal_pengajuan')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal pengajuan ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?php
    if(Yii::$app->user->can('gudang')) {
    echo $form->field($model, 'tanggal_penyetujuan')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal penyetujuan ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ;
}
    ?>

     <?= $form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>
      <?= $form->field($model, 'departemen_id')->dropDownList($listDataDept, ['prompt'=>'..Pilih Departemen..']);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
