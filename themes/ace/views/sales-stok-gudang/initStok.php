<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */
/* @var $form yii\widgets\ActiveForm */

$listDataDept=\app\models\Departemen::getListUnits();

/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */

$this->title = 'Buat Stok Barang';
$this->params['breadcrumbs'][] = ['label' => 'Stok Gudang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .spinner {
  width: 50px;
  height: 40px;
  text-align: center;
  font-size: 10px;
}

.spinner > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

.spinner .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

.spinner .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

.spinner .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

.spinner .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div class="distribusi-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="alert alert-success" id="alert-message" style="display: none"></div>
    <div class="distribusi-barang-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
    <label class="control-label">Unit Tujuan</label> 
    <?= Html::dropDownList('unit','',$listDataDept, ['prompt'=>'..Pilih Unit Tujuan..','class'=>'form-control','id'=>'unit']);?>
</div>
    <div class="form-group">
        <button class="btn btn-success" id="btn-simpan">Sinkronkan</button>
        
        <div class="spinner"  id="loading" style="display: none;" >
          <div class="rect1"></div>
          <div class="rect2"></div>
          <div class="rect3"></div>
          <div class="rect4"></div>
          <div class="rect5"></div>
        </div>
    
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>

<?php
$script = "


jQuery(function($){

    $('#btn-simpan').click(function(e){
        e.preventDefault();
        var unit = $('#unit').val();
        
        $.ajax({
            type : 'POST',
            url : '/api/sync-stok-departemen',
            data : 'dept_id='+unit,
            beforeSend: function(){
                $('#loading').show();
                $('#alert-message').hide();
            },
            success : function(data){
                $('#loading').hide();
                var hsl = jQuery.parseJSON(data);

                $('#alert-message').html('Data telah disimpan');
                $('#alert-message').show();    
                $('#alert-message').fadeOut(1000);
                

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
