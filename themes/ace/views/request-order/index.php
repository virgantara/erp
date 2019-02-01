<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RequestOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permintaan Barang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Permintaan Barang', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'no_ro',
            'petugas1',
            'petugas2',
            [
                'attribute' => 'tanggal_pengajuan',
                'value' => function($model, $url){
                    return $model->tanggal_pengajuan = $model->tanggal_pengajuan == '0000-00-00' ? '' : date('d/m/Y',strtotime($model->tanggal_pengajuan));
                }
            ],
            [
                'attribute' => 'tanggal_penyetujuan',
                'value' => function($model, $url){
                    return $model->tanggal_penyetujuan = $model->tanggal_penyetujuan == '0000-00-00' ? '' : date('d/m/Y',strtotime($model->tanggal_penyetujuan));
                }
            ],
            // 'tanggal_penyetujuan',
            'namaDeptTujuan',
            //'perusahaan_id',
           [
                'attribute' => 'is_approved',
                'label' => 'Disetujui',
                'format' => 'raw',
                'filter'=>["1"=>"Disetujui","0"=>"Belum","2"=>"Diproses"],
                'value'=>function($model,$url){

                    $st = '';
                    $label = '';

                    switch ($model->is_approved) {
                        case 1:
                            $label = 'Disetujui';
                            $st = 'success';
                            break;
                        case 2:
                            $label = 'Diproses';
                            $st = 'warning';
                            break;
                        default:
                            $label = 'Belum';
                            $st = 'danger';
                            break;
                    }
                    
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span>'.$label.'</span>
                            </button>';
                    
                },
            ],
            //'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
