<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MasterAkunSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Akuns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-akun-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Master Akun', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_akun',
            'uraian_akun',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
