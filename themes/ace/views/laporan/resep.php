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

    <table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>Tgl</th>
    		<th>Nama Px</th>
    		<th>No RM</th>
    		<th>No Resep</th>
    		<th>Jenis<br>Resep</th>
            <th>Poli</th>
            <th>Dokter</th>
            <th>Jumlah</th>
            <th>Jumlah ke<br>Apotik</th>
            <th>Total Jumlah</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
    		foreach($dataProvider->getModels() as $key => $model)
    		{
                
                $jml_sisa = 0;
                $jml_ke_apotik = 0;
                $qty = 0;
                $sisa = 0;
                $ke_apotik = 0;
                $subtotal = 0;
                foreach($model->penjualanItems as $item)
                {
                    $qty += ceil($item->qty) * round($item->harga);
                    $tmp = ceil($item->qty) - $item->jumlah_ke_apotik;
                    $sisa += $tmp;
                    $ke_apotik += $item->jumlah_ke_apotik;
                    $jml_sisa += round($item->harga) * $tmp;
                    
                    $jml_ke_apotik += ($item->jumlah_ke_apotik * round($item->harga));
                    $subtotal += ceil($item->qty) * round($item->harga);
                }

                $total += $subtotal;

                // $sisa = ($model->qty - $model->jumlah_ke_apotik) * $model->harga;

                // $subtotal_ke_apotik = $subtotal;
                // if($model->qty != $model->jumlah_ke_apotik)
                // {
                //     $subtotal_ke_apotik = $model->jumlah_ke_apotik * $model->harga;                            
                // }

                
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=date('d/m/Y',strtotime($model->tanggal));?></td>
                <td><?=$model->penjualanResep->pasien_nama;?></td>
    			<td><?=$model->penjualanResep->pasien_id;?></td>
    			<td><?=$model->kode_penjualan;?></td>
                <td><?=$listJenisResep[$model->penjualanResep->jenis_resep_id];?></td>
                <td><?=$model->penjualanResep->unit_nama;?></td>
                <td><?=$model->penjualanResep->dokter_nama;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($jml_sisa);?> </td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($jml_ke_apotik);?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($subtotal);?></td>
                

    		</tr>
    		<?php 
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align: right">Total</td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($total);?></td>
                
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