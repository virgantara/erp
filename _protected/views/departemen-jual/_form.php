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

$listDepartment = \app\models\Departemen::getListDepartemens();
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
    

    

     
    <?php 
    echo $form->field($model, 'departemen_stok_id')->widget(Select2::classname(), [
        // 'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Cari Barang ...'],
        // 'pluginEvents' => [
        //     "change" => 'function() { 
        //         var data_id = $(this).val();
                
        //         alert(data_id);
        //     }',
        // ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' =>2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],

            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                // 'success' => new JsExpression('function(data) { alert(data.text) }'),
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
        ],
    ]);
 
    ?>
    <?= $form->field($model, 'jumlah')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
