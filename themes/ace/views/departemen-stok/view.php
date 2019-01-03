<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSubStok */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perusahaan Sub Stoks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perusahaan-sub-stok-view">

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
            'departemen_id',
            'stok_akhir',
            'stok_awal',
            'created_at',
            'bulan',
            'tahun',
            'tanggal',
            'stok_bulan_lalu',
            'stok',
            'ro_item_id',
        ],
    ]) ?>

</div>
