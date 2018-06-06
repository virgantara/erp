<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

        <?php
        if(Yii::$app->user->can('gudang')){
            $label = '';
            $kode = 0;
            $warna = '';
            if($model->is_approved ==1){
                $label = 'Batal Setujui';
                $kode = 2;
                $warna = 'warning';
            }

            else{
                $label = 'Setujui';
                $kode = 1;
                $warna = 'info';
            }
            echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
                'class' => 'btn btn-'.$warna,
                'data' => [
                    'confirm' => $label.' permintaan ini?',
                    'method' => 'post',
                ],
            ]);
    } 
    ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'no_ro',
            'petugas1',
            'petugas2',
            'tanggal_pengajuan',
            'tanggal_penyetujuan',
            'perusahaan_id',
            'created',
        ],
    ]) ?>

      <p>
        <?php 
         if(Yii::$app->user->can('operatorApotik')) {
        echo Html::a('Create Request Order Item', ['/request-order-item/create','ro_id'=>$model->id], ['class' => 'btn btn-success']);
    }
         ?>
    </p>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'stok.barang.nama_barang',
            'jumlah_minta',
            'jumlah_beri',
            'satuan',
            'keterangan',
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =Url::to(['request-order-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['request-order-item/update','id'=>$model->id,'ro_id'=>$model->ro_id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['request-order-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
