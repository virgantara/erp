<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BarangRekap */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Rekaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-rekap-view">

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
            'tebus_liter',
            'tebus_rupiah',
            'dropping',
            'sisa_do',
            'jual_liter',
            'jual_rupiah',
            'stok_adm',
            'stok_riil',
            'loss',
            'tanggal',
            'barang_id',
            'perusahaan_id',
            'created',
        ],
    ]) ?>

</div>
