<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;

 use yii\jui\AutoComplete;
    use yii\helpers\Url;
    use yii\web\JsExpression;
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
    ]);

    $model->tanggal_awal = $_GET['KartuStok']['tanggal_awal'] ?: date('01-m-Y');
    $model->tanggal_akhir = $_GET['KartuStok']['tanggal_akhir'] ?: date('d-m-Y');
     ?>
    <div class="row">
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
        </div>
        <div class="col-sm-3">
            <div class="form-group">
        <label class="col-sm-3 control-label " for="form-field-1"> Kode Barang </label>

        <div class="col-sm-9">
               <?php 
            AutoComplete::widget([
    'name' => 'nama_barang_item',
    'id' => 'nama_barang_item',

    'clientOptions' => [
    'source' => Url::to(['sales-master-barang/ajax-search']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#barang_id').val(ui.item.id);
        $('#nama_barang').val(ui.item.nama);
     }")],
    'options' => [
        'size' => '40',
        'value' => '-asdf',
    ]
 ]); 
 ?>
 <input type="text" id="nama_barang_item" placeholder="Kode Barang" class="col-xs-10" />
             <input type="hidden" id="barang_id" name="barang_id"/>
                 <input type="hidden" id="nama_barang" name="nama_barang"/>
        </div>
    </div>
            
        </div>
         <div class="col-sm-3">
<div class="form-group">
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info']) ?>
    </div>

         </div>
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


<?php
$script = "


jQuery(function($){
    $('#nama_barang_item').val('".($_GET['nama_barang'] ?: '')."');
    $('#nama_barang').val('".($_GET['nama_barang'] ?: '')."');
    $('#barang_id').val('".($_GET['barang_id'] ?: '')."');
});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>
