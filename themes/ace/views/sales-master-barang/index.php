<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Data Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_barang',
            'nama_barang',

            [
             'attribute' =>'harga_beli',
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],

            ],
           [
             'attribute' =>'harga_jual',
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],

            ],
            
            'id_satuan',
            'totalStok',
            //'created',
            //'id_perusahaan',
            //'id_gudang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
