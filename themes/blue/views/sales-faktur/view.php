<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\Url;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\SalesFaktur */

$this->title = $model->id_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Sales Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-faktur-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_faktur], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_faktur], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_faktur',
            'suplier.nama',
            'no_faktur',
            'created',
            'tanggal_faktur',
            'perusahaan.nama',
        ],
    ]) ?>

     <p>
        <?= Html::a('Create Faktur Barang', ['/sales-faktur-barang/create'], ['class' => 'btn btn-success']) ?>
    </p>
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_barang',
            
            'namaGudang',
            'namaBarang',
            'barang.harga_beli',
            'barang.harga_jual',
            'jumlah',

            //'created',
            //'id_perusahaan',
            //'id_gudang',

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
                        $url =Url::to(['sales-faktur-barang/delete','id'=>$model->id_faktur_barang]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['sales-faktur-barang/update','id'=>$model->id_faktur_barang]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['sales-faktur-barang/view','id'=>$model->id_faktur_barang]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
