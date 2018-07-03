<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Perkiraan */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\ArrayHelper;

use app\models\Perusahaan;
use app\models\Perkiraan;

use kartik\select2\Select2;
use yii\web\JsExpression;


$userPt = '';
    
$where = [];

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;
}

$listData=Perusahaan::getListPerusahaans();

$listDataParent=Perkiraan::getListPerkiraans();

$url = \yii\helpers\Url::to(['/perkiraan/ajax-perkiraan']);
?>

<div class="perkiraan-form">

    <?php $form = ActiveForm::begin(); ?>
     <?php 
     echo $form->field($model, 'parent')->widget(Select2::classname(), [
        // 'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Cari perkiraan ...'],

        'pluginEvents' => [
            "change" => 'function() { 
                var data_id = $(this).val();
                
                $.ajax({
                    url : "'.\yii\helpers\Url::to(['/perkiraan/ajax-get-perkiraan']).'",
                    type : "post",
                    data : "id="+data_id,
                    success : function(res){
                        var data = $.map(res, function(value, index) {
                            return [value];
                        });

                        $("#perkiraan-level").val(data[0][2]);
                        $("#perkiraan-kode").val(data[0][3]);

                    },
                });
            }',
        ],
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
    <?= $form->field($model, 'level')->textInput(['maxlength' => 3,'readonly'=>'readonly']) ?>    
    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

   
 	<?=$form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
