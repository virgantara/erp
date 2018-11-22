<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\widgets\DetailView;

use \kartik\grid\GridView;


$this->title = $model->nama_barang.' | '.Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => 'Sales Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_barang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_barang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_barang',
            'nama_barang',
            'harga_beli',
            'harga_jual',
            'id_satuan',
            'created',
            'perusahaan.nama',
           
        ],
    ]) ?>
 <p>
    <h3>Stok Barang di Gudang</h3>
         <?= Html::a('Create Stok', ['sales-stok-gudang/create','barang_id'=>$model->id_barang], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProviderStok,
        // 'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'gudang.nama',
            'jumlah',
            [
                'label' => 'Satuan',
                'attribute' => 'barang.id_satuan'
            ]
            // 'harga_jual',
            
            //'created',

           
        ],
    ]); ?>   
<p>
    <h3>Harga Barang</h3>
        <?= Html::a('Create Barang Harga', ['barang-harga/create','barang_id'=>$model->id_barang], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'harga_beli',
            'harga_jual',
            [
                'attribute' => 'pilih',
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function($model,$url){

                    $st = $model->pilih == 1 ? 'success' : 'danger';
                    $label = $model->pilih == 1 ? 'ok' : 'remove';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span class="glyphicon glyphicon-'.$label.'"></span>
                            </button>';
                    
                },
            ],
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{pilih} {update} {delete}',
                'visibleButtons' =>
                [
                    'delete' => function ($model) {
                        return $model->pilih == 0;
                    },
                ],
                'buttons' => [
                    'delete' => function ($url, $model) {

                        $icon = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($icon, $url, [
                                    'title'        => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method'  => 'post',
                        ]);
                    }, 
                    'pilih' => function ($url, $model) {
                        // $st = $model->pilih == 1 ? 'ok' : 'remove';
                        $icon = '<span class="glyphicon glyphicon-edit"></span>';
                        return Html::a($icon, $url, [
                                   'title'        => 'Pilih dan Aktifkan Harga',
                                    'data-confirm' => Yii::t('yii', 'Pilih harga item ini?'),
                                    'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'pilih') {

                        $url =Url::to(['sales-master-barang/pilih-harga','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'delete') {
                        $url =Url::to(['barang-harga/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['barang-harga/update','id'=>$model->id,'barang_id'=>$model->barang_id]);
                        return $url;
                    }


                  }
            ],
        ],
    ]); ?>
</div>
