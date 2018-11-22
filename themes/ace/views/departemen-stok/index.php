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

  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'namaBarang',
            'namaDepartemen',
            'barang.id_satuan',
            // 'stok_akhir',
            // 'stok_awal',
            //'created',
            //'bulan',
            //'tahun',
            //'tanggal',
            //'stok_bulan_lalu',
            'stok',
            //'ro_item_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
