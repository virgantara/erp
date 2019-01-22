<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangOpnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Opnames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-opname-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Opname', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'barang_id',
            'perusahaan_id',
            'departemen_stok_id',
            'stok',
            //'stok_riil',
            //'stok_lalu',
            //'bulan',
            //'tahun',
            //'tanggal',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
