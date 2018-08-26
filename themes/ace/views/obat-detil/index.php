<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObatDetilSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Obat Detils';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obat-detil-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Obat Detil', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'barang_id',
            'nama_generik',
            'kekuatan',
            'satuan_kekuatan',
            //'jns_sediaan',
            //'b_i_r',
            //'gen_non',
            //'nar_p_non',
            //'oakrl',
            //'kronis',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
