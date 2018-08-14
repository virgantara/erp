<?php
use yii\helpers\Url;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */

$this->title = $model->id_gudang;
$this->params['breadcrumbs'][] = ['label' => 'Sales Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-gudang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_gudang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_gudang], [
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
            // 'id_gudang',
            'nama',
            'alamat',
            'telp',
            
        ],
    ]) ?>
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_barang',
            'barang.nama_barang',
            'barang.harga_beli',
            'barang.harga_jual',
            'jumlah',
            'barang.id_satuan',
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
                        $url =Url::to(['sales-stok-gudang/delete','id'=>$model->id_stok]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['sales-stok-gudang/update','id'=>$model->id_stok]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['sales-stok-gudang/view','id'=>$model->id_barang]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>
