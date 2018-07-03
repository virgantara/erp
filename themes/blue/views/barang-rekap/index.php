<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangRekapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Rekaps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-rekap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Rekap', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'tebus_liter',
            'tebus_rupiah',
            'dropping',
            'sisa_do',
            //'jual_liter',
            //'jual_rupiah',
            //'stok_adm',
            //'stok_riil',
            //'loss',
            //'tanggal',
            //'barang_id',
            //'perusahaan_id',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
