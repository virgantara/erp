<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TrRawatInapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Pasien Kamar';
$this->params['breadcrumbs'][] = $this->title;

$golPasien = \app\models\GolPasien::find()->where(['IsKaryawan'=>1])->all();
$listGolPasien=\yii\helpers\ArrayHelper::map($golPasien,'KodeGol','NamaGol');
?>
<div class="tr-rawat-inap-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           'noRM',
            'namaPasien',
             [
                'attribute' => 'jenis_pasien',
                'headerOptions' => ['style' => 'width:20%'],
                'label' => 'Jns Px',
                'format' => 'raw',
                'filter'=>$listGolPasien,
                'value'=>function($model,$url){
                    $st = 'info';
                    $golPasien = $model->jenisPasien->NamaGol;
                    $label = $golPasien;
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
  
            'namaKamar',
            [
                'attribute'=>'datetime_masuk',
                'format' => 'datetime'
            ],
            [
                'attribute'=>'datetime_keluar',
                'format' => 'datetime'
            ],
             [
                'attribute' => 'status_inap',
                'label' => 'Status Inap',
                'format' => 'raw',
                'filter'=>["Keluar Kamar","Sedang Dirawat","Pulang"],
                'value'=>function($model,$url){
                    $st = '';
                    $label = '';
                    switch ($model->status_inap) {
                        case 0:
                            $label = 'Keluar Kamar';
                            $st = 'warning';
                            break;
                        case 1 :
                            $label = 'Sedang dirawat';
                            $st = 'success';
                            break;
                        case 2 :
                            $label = 'Pulang';
                            $st = 'danger';
                            break;
                        
                    }
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
  

            [
                'class' => 'yii\grid\ActionColumn',
                 'template' => '{obat} ',
                 'buttons' => [
                    'obat' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list-alt" style="font-size:20px">', $url, [
                                   'title'        => 'Input Obat Pasien',
                                   
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'obat') {
                        $url =\yii\helpers\Url::to(['tr-rawat-inap-alkes-obat/create','id'=>$model->id_rawat_inap]);
                        return $url;
                    }


                }
            ],
        ],
    ]); ?>
</div>
