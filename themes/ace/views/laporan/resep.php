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
$listJenisResep = \app\models\JenisResep::getListJenisReseps();

$this->title = 'Laporan Resep';
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = !empty($_GET['Penjualan']['tanggal_awal']) ? $_GET['Penjualan']['tanggal_awal'] : date('Y-m-d');
$model->tanggal_akhir = !empty($_GET['Penjualan']['tanggal_akhir']) ? $_GET['Penjualan']['tanggal_akhir'] : date('Y-m-d');
?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => array('laporan/resep')
    ]); ?>
    <table>
        <tr>
            <td>
                 <?= $form->field($model, 'tanggal_awal')->widget(
        yii\jui\DatePicker::className(),[
            // 'value' => date('d-m-Y'),
            'options' => ['placeholder' => 'Pilih tanggal awal ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]
    ) ?> 
            </td>
            <td>
                 <label class="control-label" for="jenis_rawat">Jenis Rawat</label>
                 <select name="jenis_rawat" id="jenis_rawat" class="input-sm">
                    
                    <option value="1">Rawat Jalan</option>
                    <option value="2">Rawat Inap</option>
                </select>
                <label class="control-label">Jenis Resep</label>
                <?= Html::dropDownList('jenis_resep_id',!empty($_GET['jenis_resep_id']) ? $_GET['jenis_resep_id'] : $_GET['jenis_resep_id'],$listJenisResep, ['prompt'=>'..Pilih Jenis Resep..','id'=>'jenis_resep_id']);?>
            </td>
        </tr>
        <tr>
            <td>
                 <?= $form->field($model, 'tanggal_akhir')->widget(
        yii\jui\DatePicker::className(),[
            // 'value' => date('d-m-Y'),
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]
    ) ?> 
               
            </td>
            <td>
               <label class="control-label" for="unit_id">Unit</label>
                 
                 <select name="unit_id" id="unit_id">
                     
                 </select>
            </td>
        </tr>
    </table>
    <div class="col-sm-3">

 
</div>
<div class="col-sm-3">

    <div class="form-group"><br>
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1]) ?>    
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Export XLS', ['class' => 'btn btn-success','name'=>'export','value'=>1]) ?>    
    </div>

</div>
     


    <?php ActiveForm::end(); ?>

    <table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>Tgl</th>
    		<th>Nama Px</th>
    		<th>No RM</th>
    		<th>No Resep</th>
    		<th>Poli</th>
            <th>Dokter</th>
            
            <th>Jumlah</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
    		foreach($dataProvider->getModels() as $key => $model)
    		{
                $subtotal = \app\models\Penjualan::getTotalSubtotal($model);
                $total += $subtotal;
      
                
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=date('d/m/Y',strtotime($model->tanggal));?></td>
                <td><?=$model->penjualanResep->pasien_nama;?></td>
    			<td><?=$model->penjualanResep->pasien_id;?></td>
    			<td><?=$model->kode_penjualan;?></td>
                <td><?=$model->penjualanResep->unit_nama;?></td>
                <td><?=$model->penjualanResep->dokter_nama;?></td>
                <td><?=$subtotal;?></td>
                

    		</tr>
    		<?php 
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right">Total</td>
                <td><?=$total;?></td>
                
            </tr>
        </tfoot>
    </table>
   
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