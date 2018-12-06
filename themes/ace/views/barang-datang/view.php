<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BarangDatang */

$this->title = 'Dropping | '.$model->noSo;
$this->params['breadcrumbs'][] = ['label' => 'Barang Datangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-datang-view">

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
            'namaBarang',
            'noSo',
            'no_lo',
            'tanggal_lo',
            'tanggal',
            'namaGudang',
            'jumlah',
            'namaShift',
            'namaPerusahaan',
            'created_at',
            'updated_at',
            
        ],
    ]) ?>

</div>
