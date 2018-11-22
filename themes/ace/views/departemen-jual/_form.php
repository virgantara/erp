<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use kartik\depdrop\DepDrop;
use kartik\date\DatePicker;

use kartik\select2\Select2;
use yii\web\JsExpression;

$listData=\app\models\Perusahaan::getListPerusahaans();
$where = [];

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;
}

 $url = \yii\helpers\Url::to(['/departemen-stok/ajax-stok-barang']);
?>

<div class="departemen-jual-form">

    <?php $form = ActiveForm::begin(); ?>

     <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    

    
    <?= $form->field($model, 'jumlah')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
