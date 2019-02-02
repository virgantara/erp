<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Perusahaan;
use app\models\MasterJenisBarang;
use kartik\depdrop\DepDrop;


$listData=Perusahaan::getListPerusahaans();
$listJenis=MasterJenisBarang::getList();

// $list=SalesGudang::find()->where(['jenis' => '3'])->all();
// $listSatuan=ArrayHelper::map($list,'id_satuan','nama');


use kartik\select2\Select2;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['/perkiraan/ajax-perkiraan']);
?>

<div class="sales-master-barang-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->field($model, 'jenis_barang_id')->dropDownList($listJenis, ['prompt'=>'..Jenis..','id'=>'jenis_barang_id']);?>
    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>

  
    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>
     <?= $form->field($model, 'id_satuan')->textInput() ?>
    

    
     

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs(" 

$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        var inputs = $(this).closest('form').find(':input:visible');
              
        inputs.eq( inputs.index(this)+ 1 ).focus().select();
        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 10);


    }
});

$(document).on('keydown','#salesmasterbarang-harga_beli', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        obj = new Object;
        obj.harga = $(this).val();
        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/margin/ajax-get-harga-margin',

            success : function(data){
                
                var hsl = jQuery.parseJSON(data);
                $('#salesmasterbarang-harga_jual').val(hsl.items);
            }
        });

    }
 
});

", \yii\web\View::POS_READY);

?>