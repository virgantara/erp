<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PiutangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Piutangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="piutang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Piutang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kwitansi',
            'penanggung_jawab',
            'perkiraan_id',
            'keterangan:ntext',
            //'tanggal',
            //'qty',
            //'created',
            //'perusahaan_id',
            //'kode_transaksi',
            //'customer_id',
            //'no_nota',
            //'is_lunas',
            //'barang_id',
            //'rupiah',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
