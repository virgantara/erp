<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ObatDetil */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Obat Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obat-detil-view">

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
            'nama_generik',
            'kekuatan',
            'satuan_kekuatan',
            'jns_sediaan',
            'b_i_r',
            'gen_non',
            'nar_p_non',
            'oakrl',
            'kronis',
        ],
    ]) ?>

</div>
