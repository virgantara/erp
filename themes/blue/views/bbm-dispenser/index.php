<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BbmDispenserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bbm Dispensers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-dispenser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Bbm Dispenser', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama',
            'namaPerusahaan',
            'namaBarang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
