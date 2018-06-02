<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangStokSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Stoks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-stok-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Stok', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Rekap', ['rekap'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'namaBarang',
            'tanggal',
            //'stok_bulan_lalu',
            'tebus_liter',
            'tebus_rupiah',
            'dropping',
            'sisa_do',
            //'perusahaan_id',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
