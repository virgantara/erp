<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PiutangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Piutang | '.Yii::$app->params['shortname'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="piutang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_nota',
            // 'penanggung_jawab',
            'namaPerkiraan',
            [
                'attribute' => 'nilai',
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->nilai);
                }
            ],
            'keterangan:ntext',
             [
                'attribute' => 'is_lunas',
                'label' => 'Status',
                'format' => 'raw',
                'filter'=>["1"=>"Lunas","0"=>"Belum"],
                'value'=>function($model,$url){

                    $st = $model->is_lunas == 1 ? 'success' : 'danger';
                    $label = $model->is_lunas == 1 ? 'Lunas' : 'Belum';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            //'tanggal',

            //'created',
            //'perusahaan_id',
            //'kode_transaksi',

        ],
    ]); ?>
</div>
