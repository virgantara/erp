<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

// use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penjualan Obat';
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = !empty($_GET['Penjualan']['tanggal_awal']) ? $_GET['Penjualan']['tanggal_awal'] : date('Y-m-d');
$model->tanggal_akhir = !empty($_GET['Penjualan']['tanggal_akhir']) ? $_GET['Penjualan']['tanggal_akhir'] : date('Y-m-d');
?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => array('laporan/penjualan')
    ]); ?>
    <div class="col-sm-3">

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
</div>
<div class="col-sm-3">
    <?php
    echo $form->field($model, 'tanggal_akhir')->widget(
        yii\jui\DatePicker::className(),[ 
            // 'value' => date('Y-m-d'),
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]
    ) ;

    ?>

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
    		<th>Kode</th>
    		<th>Nama</th>
    		<th>Qty</th>
    		<th>HB</th>
            <th>HJ</th>
            
            <th>Laba</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
            $total_laba = 0;
    		foreach($results as $key => $model)
    		{

                // print_r($model);exit;

                $laba = ($model->stok->barang->harga_jual - $model->stok->barang->harga_beli) * $model->qty;
                $total += $laba;
                
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=date('d/m/Y',strtotime($model->penjualan->tanggal));?></td>
                <td><?=$model->stok->barang->kode_barang;?></td>
    			<td><?=$model->stok->barang->nama_barang;?></td>
    			<td><?=$model->qty;?></td>
                <td><?=$model->stok->barang->harga_beli;?></td>
                <td><?=$model->stok->barang->harga_jual;?></td>
                <td><?=$laba;?></td>
                

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
