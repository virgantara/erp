<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerusahaanSubStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Unit Stoks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perusahaan-sub-stok-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stok Unit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'namaBarang',
            'namaDepartemen',
            
            'batch_no',
            'exp_date',
            'barang.id_satuan',
            'barang.harga_jual',
            'barang.harga_beli',
            // 'stok_akhir',
            // 'stok_awal',
            //'created',
            //'bulan',
            //'tahun',
            //'tanggal',
            //'stok_bulan_lalu',
            'stok',
            //'ro_item_id',
            [
             
                'label' => 'Kondisi Stok',
                'format' => 'raw',
                'filter'=>["1"=>"Disetujui","0"=>"Belum","2"=>"Diproses"],
                'value'=>function($model,$url){

                    $st = '';
                    $label = '';

                    if ($model->stok > 0 && $model->stok <= $model->stok_minimal) {
                        $label = 'Kurang';
                        $st = 'warning';
                    }

                    else if($model->stok <= 0){
                        $label = 'Habis';
                        $st = 'danger';
                            
                    }

                    else{
                        $label = 'Mencukupi';
                        $st = 'success';
                    }
                    
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
