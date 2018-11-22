<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesFakturSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Fakturs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-faktur-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sales Faktur', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_faktur',
            'suplier.nama',
            'no_faktur',
            'created',
            'tanggal_faktur',
            //'id_perusahaan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    
</div>
