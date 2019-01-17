<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kartu Stok Barang : '.(!empty($barang) ? $barang->nama_barang : '');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => array('sales-stok-gudang/kartu')
    ]); ?>

   <?= $form->field($model, 'tanggal_awal')->widget(
        DatePicker::className(),[
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal awal ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>

    <?php
    echo $form->field($model, 'tanggal_akhir')->widget(
        DatePicker::className(),[ 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ;

    ?>


      <?= $form->field($model, 'barang_id')->widget(AutocompleteAjax::classname(), [
	    'multiple' => false,
	    'url' => ['sales-master-barang/ajax-search'],
	    'options' => ['placeholder' => 'Cari Barang..']
	]) ?>

    <div class="form-group">
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
    		
            <th>Tanggal</th>
    		<th>Masuk</th>
    		<th>Keluar</th>
    		<th>Sisa</th>
            <th>No Batch</th>
            <th>Exp Date</th>
    		<th>Keterangan</th>
    	</tr>
    	</thead>
    	<tbody>
    		<?php 

            $stok = 0;
    		foreach($results as $key => $model)
    		{
                $qin = $model['masuk'];
                $qout = $model['keluar'];
                

                $stok += $qin;
                $stok -= $qout;
                $sisa = $stok;
    		?>
    		<tr>
    			<td><?=$key+1;?></td>
    			<td><?=$model['item']->tanggal;?></td>
    			<td><?=$qin;?></td>
    			<td><?=$qout;?></td>
    			<td><?=$sisa;?></td>
                <td><?=$model['batch_no'];?></td>
                <td><?=$model['exp_date'];?></td>
    			<td><?=$model['keterangan'];?></td>
    		</tr>
    		<?php 
    	}
    		?>
    	</tbody>
    </table>
   
</div>
