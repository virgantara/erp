<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\Url;
use yii\grid\GridView;

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bbm Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-faktur-view">

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
        $label = '';
            $kode = 0;
            $warna = '';
            if($model->is_selesai ==1){
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
                    'confirm' => $label.' pembelian ini?',
                    'method' => 'post',
                ],
            ]);
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'suplier.nama',
            'no_lo',
            'tanggal_lo',
            'no_so',
            'tanggal_so',
            'perusahaan.nama',
            'created',
        ],
    ]) ?>


      <p>
        <?= Html::a('Create Bbm Faktur Item', ['/bbm-faktur-item/create','faktur_id'=>$model->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'barang.nama_barang',
            'jumlah',
            'stok.gudang.nama',
            'created',

             [
                'class' => 'yii\grid\ActionColumn',
                // 'visible'=>Yii::$app->user->can('adm'),
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
                        $url =Url::to(['bbm-faktur-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['bbm-faktur-item/update','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['bbm-faktur-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
