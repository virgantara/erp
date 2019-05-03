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

$this->title = 'Laporan Rekapitulasi Nominal Resep '.(!empty($_GET['jenis_resep_id']) ? $listJenisResep[$_GET['jenis_resep_id']] : '');
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = !empty($_GET['Penjualan']['tanggal_awal']) ? $_GET['Penjualan']['tanggal_awal'] : date('Y-m-d');
$model->tanggal_akhir = !empty($_GET['Penjualan']['tanggal_akhir']) ? $_GET['Penjualan']['tanggal_akhir'] : date('Y-m-d');
?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => array('laporan/resep-rekap')
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
              <label class="control-label">Jenis Resep</label>
                <?= Html::dropDownList('jenis_resep_id',!empty($_GET['jenis_resep_id']) ? $_GET['jenis_resep_id'] : $_GET['jenis_resep_id'],$listJenisResep, ['prompt'=>'..Pilih Jenis Resep..','id'=>'jenis_resep_id']);?>
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
            <th>Poli</th>
    		<th>Jml Resep</th>
    		<th>Nominal Resep</th>
    		<th>Rata-rata Resep</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
            $jml = 0;
            $total_avg = 0;
    		foreach($results as $key => $model)
    		{
               
                $jml += $model['count'];
                $total += $model['total'];
                $total_avg += $model['avg'];
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=$model['label'];?></td>
                <td style="text-align: right"><?=$model['count'];?></td>
    			<td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($model['total'],2);?></td>
    			<td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($model['avg'],2);?></td>
               
    		</tr>
    		<?php 
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right">Total</td>
                <td style="text-align: right"><?=$jml;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($total,2);?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($total_avg,2);?></td>
                
            </tr>
        </tfoot>
    </table>
   
</div>
<?php

$script = "


$(document).ready(function(){
   

});

";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>