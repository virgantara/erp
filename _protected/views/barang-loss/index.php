<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BarangLossSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Barang Losses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-loss-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Barang Loss', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'namaBarang',
            // 'bulan',
            // 'tahun',
            [
                'attribute' =>'tanggal',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->tanggal);
                }
            ],
            //'jam',
            [
                'attribute' =>'stok_adm',
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->stok_adm);
                }
            ],
            [
                'attribute' =>'stok_riil',
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->stok_riil);
                }
            ],
            [
                'attribute' =>'loss',
                'format' => 'raw',
                'filter'=>['Loss '. html_entity_decode("&lt;")." 1 %","1% ".html_entity_decode("&le;")." Loss ".html_entity_decode("&le;")." 5 %",'Loss '.html_entity_decode("&gt;")." 5%"],
                'value' => function($model){
                    $st = '';
                    $label = Yii::$app->formatter->asPercent($model->loss,3);
                            

                    if ($model->loss * 100 < 1) 
                        $st = 'success';
                    else if ($model->loss * 100 >= 1 && $model->loss * 100 <= 5)
                        $st = 'warning';
                    else
                        $st = 'danger';
                        
                           
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                }
            ],
            //'biaya_loss',
            //'created',
            //'perusahaan_id',

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
