<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ReturItem */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Retur Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-item-view">

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
            'retur_id',
            'barang_id',
            'qty',
            'keterangan',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
