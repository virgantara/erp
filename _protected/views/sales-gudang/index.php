<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalesGudangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales Gudangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-gudang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sales Gudang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama',
            'alamat',
            'telp',
            'kapasitas',
            [
                'attribute' => 'is_sejenis',
                'format' => 'raw',
                'value'=>function($model,$url){

                    $st = $model->is_sejenis == 1 ? 'success' : 'warning';
                    $label = $model->is_sejenis == 1 ? 'Ya' : 'Tidak';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            [
                'attribute' => 'is_penuh',
                'format' => 'raw',
                'value'=>function($model,$url){

                    $st = $model->is_penuh == 1 ? 'danger' : 'success';
                    $label = $model->is_penuh == 1 ? 'Penuh' : 'Tidak';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            // 'id_perusahaan',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>