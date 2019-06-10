<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\form\ActiveForm;
// use keygenqt\autocompleteAjax\AutocompleteAjax;
// use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Penjualan Obat';
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = !empty($_GET['PenjualanItem']['tanggal_awal']) ? $_GET['PenjualanItem']['tanggal_awal'] : date('Y-m-d');
$model->tanggal_akhir = !empty($_GET['PenjualanItem']['tanggal_akhir']) ? $_GET['PenjualanItem']['tanggal_akhir'] : date('Y-m-d');
?>
<div class="sales-stok-gudang-index row">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
    	'method' => 'get',
    	'action' => array('laporan/penjualan')
    ]);
?>

<div class="col-sm-3">

<?php

$model->date_range = !empty($_GET['PenjualanItem']) ? $_GET['PenjualanItem']['date_range'] : date('01-m-Y').' sampai '.date('t-m-Y');

echo $form->field($model, 'date_range', [
    'addon'=>['prepend'=>['content'=>'<i class="fa fa-calendar"></i>']],
    'options'=>['class'=>'drp-container form-group']
])->widget(DateRangePicker::classname(), [
    'useWithAddon'=>true,
    'convertFormat'=>true,
    'startAttribute' => 'tanggal_awal',
    'endAttribute' => 'tanggal_akhir',
    'pluginOptions'=>[
        'locale'=>[
            'format'=>'d-m-Y',
            'separator'=>' sampai ',
        ],
        'opens'=>'left'
    ],
    'options'=>[
        'autocomplete' => 'off'
    ]
]);

     ?>
    


</div>

<div class="col-sm-3">

    <div class="form-group"><br>
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1]) ?>    
        <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Export XLS', ['class' => 'btn btn-success','name'=>'export','value'=>1]) ?>    
    </div>

</div>
    </div> 


    <?php ActiveForm::end(); ?>
 <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <i class="icon fa fa-exclamation"></i> <?= Yii::$app->session->getFlash('error') ?>
         
    </div>
<?php endif; ?>
  <?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'penjualan.tanggal',
            'penjualan.kode_penjualan',
            'stok.barang.kode_barang',
            'stok.barang.nama_barang',
            'qty',
            [
                'header' => 'HB',
                'value' => function($data){
                    return \app\helpers\MyHelper::formatRupiah($data->harga_beli,2);
                }
            ],
            [
                'header' => 'HJ',
                'value' => function($data){
                    return \app\helpers\MyHelper::formatRupiah($data->harga,2);
                }
            ],
            [
                'header' => 'Laba',
                'value' => function($data){
                    $hb = $data->harga_beli;
                    $hj = $data->harga;
                    $qty = $data->qty;
                    $laba = $qty * ($hj - $hb);
                    return \app\helpers\MyHelper::formatRupiah($laba,2);
                }
            ],
            
            // ['class' => 'yii\grid\ActionColumn'],
        ],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
    <?php 

   // echo $this->render('_tabel_penjualan', [
   //          'searchModel' => $searchModel,
   //          'dataProvider' => $dataProvider,
   //          'model' => $model,
   //          'results' => $results,
   //          'export' => $export
   //      ]); 
    ?>
   
</div>
