<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BarangHarga */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Hargas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-harga-view">

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
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'barang_id',
            'harga_beli',
            'harga_jual',
            [
                'attribute' => 'pilih',
                'format' => 'raw',
                'value'=>function($model,$url){
                    $st = $model->pilih == 1 ? 'ok' : 'remove';
                    return '<span class="glyphicon glyphicon-'.$st.'"></span>';
                    
                },
            ],
            'created',
        ],
    ]) ?>

</div>
