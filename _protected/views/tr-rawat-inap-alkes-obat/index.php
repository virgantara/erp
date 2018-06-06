<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrRawatInapAlkesObatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tr Rawat Inap Alkes Obats';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-rawat-inap-alkes-obat-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tr Rawat Inap Alkes Obat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_rawat_inap',
            'kode_alkes',
            'keterangan',
            'nilai',
            //'created',
            //'id_m_obat_akhp',
            //'tanggal_input',
            //'id_dokter',
            //'jumlah',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
