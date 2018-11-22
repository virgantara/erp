<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BarangLoss */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Losses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-loss-view">

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
            'bulan',
            'tahun',
            'tanggal',
            'jam',
            'stok_adm',
            'stok_riil',
            'loss',
            'biaya_loss',
            'created',
            'perusahaan_id',
        ],
    ]) ?>

</div>
