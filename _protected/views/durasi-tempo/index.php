<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DurasiTempoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Durasi Tempos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="durasi-tempo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Durasi Tempo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nama',
            'durasi',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
