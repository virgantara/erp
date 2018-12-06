<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\StokAwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stok Awals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-awal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Stok Awal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'barang.nama_barang',
            'gudang.nama',
            'tanggal',
            'bulan',
            'tahun',
            //'created',
            'stok',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
