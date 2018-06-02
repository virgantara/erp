<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Kas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-form">

    <?php $form = ActiveForm::begin(['action'=>['kas/keluar','uk'=>$uk]]); 
    $model->jenis_kas =0;
    ?>



    <?php 
    $url = \yii\helpers\Url::to(['/perkiraan/ajax-perkiraan']);
 
    // $cityDesc = empty($model->perkiraan_id) ? '' : Perkiraan::findOne($model->city)->description;
    echo $form->field($model, 'perkiraan_id')->widget(Select2::classname(), [
        // 'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Cari perkiraan ...'],
     
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


    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('Y-m-d', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?= $form->field($model, 'kas_keluar')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
