<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotifSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notifs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Notif', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'keterangan',
            'user_from_id',
            'user_to_id',
            'is_read_user_from',
            //'is_read_user_to',
            //'is_hapus',
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
