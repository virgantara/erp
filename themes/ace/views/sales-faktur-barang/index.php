<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesFakturBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Faktur Barangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-faktur-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sales Faktur Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_faktur_barang',
            'id_faktur',
            'id_barang',
            'jumlah',
            'id_satuan',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

   
</div>
