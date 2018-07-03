<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SatuanBarangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Satuan Barangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="satuan-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Satuan Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_satuan',
            'kode',
            'nama',
            'jenisPerusahaan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
