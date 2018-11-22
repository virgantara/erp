<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesStokGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Status Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-stok-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
     echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'namaGudang',
            'namaBarang',
            'batch_no',
            'jumlah',
            'exp_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
