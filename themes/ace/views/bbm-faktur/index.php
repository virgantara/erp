<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BbmFakturSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bbm Fakturs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-faktur-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bbm Faktur', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'namaSuplier',
            
            'no_so',
            'tanggal_so',
            [
                'label' => 'Item',
                'format' => 'raw',
                'value' => function($model,$i) {
                    return implode(',', \yii\helpers\ArrayHelper::map($model->bbmFakturItems, 'barang_id', 'barang.nama_barang'));
                }, 
            ],
            [
             'label' => 'Volume',
              'value' => function($model,$i) {
                    return $model->volume;
                },      
           ],
            [
                'attribute' => 'is_selesai',
                'label' => 'Status',
                'format' => 'raw',
                'filter'=>["1"=>"Selesai","0"=>"Belum"],
                'value'=>function($model,$url){

                    $st = $model->is_selesai == 1 ? 'success' : 'danger';
                    $label = $model->is_selesai == 1 ? 'Selesai' : 'Belum';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            //'perusahaan_id',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
