<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BbmDispenserLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bbm Dispenser Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-dispenser-log-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bbm Dispenser Log', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'dispenser_id',
            'shift_id',
            'perusahaan_id',
            'jumlah',
            //'tanggal',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
