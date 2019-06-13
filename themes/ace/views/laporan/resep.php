<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

// use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use app\models\JenisResep;


$this->title = 'Laporan Resep';
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = $_GET['Penjualan']['tanggal_awal'] ?: date('Y-m-01');
$model->tanggal_akhir = $_GET['Penjualan']['tanggal_akhir'] ?:date('Y-m-d');

?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => ['laporan/resep'],
        'options' => [
            'class' => 'form-horizontal'
        ]
    ]); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Awal</label>
        <div class="col-lg-2 col-sm-10">
          <?= yii\jui\DatePicker::widget(
            [
                'model' => $model,
                'attribute' => 'tanggal_awal',
            // 'value' => date('d-m-Y'),
            'options' => ['placeholder' => 'Pilih tanggal awal ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]      
    ) ?> 
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Akhir</label>
        <div class="col-lg-2 col-sm-10">
          <?= yii\jui\DatePicker::widget(
            [
                'model' => $model,
                'attribute' => 'tanggal_akhir',
            // 'value' => date('d-m-Y'),
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]      
    ) ?> 
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Rawat</label>
        <div class="col-lg-2 col-sm-10">
            <?= Html::dropDownList('jenis_rawat',!empty($_GET['jenis_rawat']) ? $_GET['jenis_rawat'] : $_GET['jenis_rawat'],['1'=>'Rawat Jalan','2'=>'Rawat Inap'], ['prompt'=>'..Pilih Jenis Rawat..','id'=>'jenis_rawat']);?>
                 </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Resep</label>
        <div class="col-lg-2 col-sm-10">
        <?= Html::dropDownList('jenis_resep_id',!empty($_GET['jenis_resep_id']) ? $_GET['jenis_resep_id'] : $_GET['jenis_resep_id'],$listJenisResep, ['prompt'=>'..Pilih Jenis Resep..','id'=>'jenis_resep_id']);?>
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Unit</label>
        <div class="col-lg-2 col-sm-10">
         <select name="unit_id" id="unit_id">
                     
                 </select>
        </div>
    </div>
     
    <div class="col-sm-2">

 
</div>
<div class="col-sm-3">

    <div class="form-group"><br>
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1]) ?>    
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Export XLS', ['class' => 'btn btn-success','name'=>'export','value'=>1]) ?>    
    </div>

</div>
     


    <?php ActiveForm::end(); ?>

   <?php 

   echo $this->render('_tabel_resep', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'results' => $results,
            'export' => $export,
            'listJenisResep' => $listJenisResep
        ]); 
    ?>
   
</div>
</div>
<?php

$uid = !empty($_GET['unit_id']) ? $_GET['unit_id'] : '';
$script = "

function fetchAllRefUnit(tipe){
    $.ajax({
        type : 'POST',
        data : 'tipe='+tipe,
        url : '/api/ajax-all-ref-unit',

        success : function(data){
            var data = $.parseJSON(data);
            
            $('#unit_id').empty();
            var row = '';
            row += '<option value=\"\">- Pilih Unit -</option>';
            $.each(data,function(i, obj){
                if(obj.id == '".$uid."')
                    row += '<option selected value='+obj.id+'>'+obj.label+'</option>';
                else
                    row += '<option value='+obj.id+'>'+obj.label+'</option>';
            });

            $('#unit_id').append(row);
            
        }

    });
}

$(document).ready(function(){
    fetchAllRefUnit(1);

    $('#jenis_rawat').change(function(){
        fetchAllRefUnit($(this).val());
    });
});

";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>