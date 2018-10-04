<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MarginSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Margins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="margin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Margin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           
            'batas_bawah',
            'batas_atas',
            'persentase',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
