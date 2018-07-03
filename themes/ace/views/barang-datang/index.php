<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangDatangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Datang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-datang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Datang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tanggal',
            'jam',
            'namaBarang',
            'jumlah',
            'namaShift',
            'namaPerusahaan',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
