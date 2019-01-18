<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use kartik\date\DatePicker;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laporan Pengeluaran Barang';
$this->params['breadcrumbs'][] = $this->title;

$model->tanggal_awal = !empty($_GET['RequestOrder']['tanggal_awal']) ? $_GET['RequestOrder']['tanggal_awal'] : date('Y-m-d');
$model->tanggal_akhir = !empty($_GET['RequestOrder']['tanggal_akhir']) ? $_GET['RequestOrder']['tanggal_akhir'] : date('Y-m-d');

?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => array('laporan/mutasi-keluar')
    ]); ?>
    <div class="col-sm-3">
   <?= $form->field($model, 'tanggal_awal')->widget(
        \yii\jui\DatePicker::className(),[
            // 'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal awal ...'],
            'dateFormat' => 'php:d-m-Y',
            // 'pluginOptions' => [
            //     'format' => 'dd-mm-yyyy',
            //     'todayHighlight' => true
            // ]
        ]
    ) ?>
</div>
<div class="col-sm-3">
    <?php
    echo $form->field($model, 'tanggal_akhir')->widget(
        \yii\jui\DatePicker::className(),[ 
            // 'value' => date('d-M-Y', strtotime('0 days')),
            'dateFormat' => 'php:d-m-Y',
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            // 'pluginOptions' => [
            //     'format' => 'dd-mm-yyyy',
            //     'todayHighlight' => true
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

    <?php 
   echo $this->render('_tabel_mutasi_keluar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'results' => $results
        ]); 
    ?>
   
</div>
