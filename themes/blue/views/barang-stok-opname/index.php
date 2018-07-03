<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangStokOpnameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Stok Opnames';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-stok-opname-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Stok Opname', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'namaBarang',
            'namaGudang',
            'namaShift',
            // 'namaPerusahaan',

            [
                'attribute' => 'stok',
                'format'=>'raw',
                'contentOptions' => ['style'=>'text-align: right;'],
                'value' => function($model){
                    return Yii::$app->formatter->asInteger($model->stok);
                }
            ],
            //'stok_lalu',
            //'bulan',
            //'tahun',
            [
                'attribute' => 'tanggal',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->tanggal);
                }
            ],
            'jam',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
