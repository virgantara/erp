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

// print_r($model->tanggal);exit;

$listData=Perusahaan::getListPerusahaans();

$listDispenser = BbmDispenser::getListDispensers();
?>

<div class="bbm-jual-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model) ?>
    <?= $form->field($model, 'tanggal',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(
        DatePicker::className(),[
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Pilih tanggal transaksi ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    

    <?= $form->field($model, 'barang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataBarang, ['prompt'=>'.. Pilih BBM','id'=>'barang_id']); ?>
    <?php
    echo $form->field($model, 'dispenser_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(DepDrop::classname(), [
        'options'=>['id'=>'dispenser_id'],
        'pluginOptions'=>[
            'depends'=>['barang_id'],
            'placeholder'=>'..Pilih Dispenser..',
            'url'=>Url::to(['/sales-master-barang/get-dispenser'])
        ]
    ]);
     ?>

    <?= $form->field($model, 'shift_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataShift, ['prompt'=>'.. Pilih Shift']); ?>
    <?= $form->field($model, 'stok_awal',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput() ?>
    <?= $form->field($model, 'stok_akhir',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput() ?>
    
    <!-- <label class="control-label">Durasi Jatuh Tempo</label> -->
    <?php 
    // echo \yii\helpers\Html::dropDownList('durasi_tempo', null,
    //   \yii\helpers\ArrayHelper::map(\app\models\DurasiTempo::find()->all(), 'id', 'nama'),['class'=>'form-control']) ;
      ?>
    <?php 
    // $form->field($model, 'no_nota')->textInput() 
    ?>
    
    <?= $form->field($model, 'perusahaan_id',['options'=>['class'=>'form-group col-xs-12 col-lg-12']])->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>
    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success','name'=>'input-saja','value'=>1]) ?>
        <?= Html::submitButton('Simpan & Input Lagi', ['class' => 'btn btn-success','name'=>'input-lagi','value'=>1]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = "

jQuery(function($){

    $('#bbmjual-shift_id').on('change',function(){
        
        item = new Object;
        item.barang_id = $('#barang_id').val();
        item.dispenser_id = $('#dispenser_id').val();;
        item.tanggal = $('#bbmjual-tanggal').val();
        
        if(item.barang_id == '' || item.dispenser_id == '' || item.tanggal == ''){
            alert('Barang, Dispenser, Tanggal harus diisi');
            return;
        }

        $.ajax({
            type : 'POST',
            url : '/bbm-dispenser-log/ajax-get-angka-dispenser',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);
                
                if(hsl.code == '200'){
                    $('#bbmjual-stok_awal').val(hsl.jumlah);
                    // alert(hsl.jumlah);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

    

});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>