<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BarangStokOpname */

$this->title = 'Update Barang Stok Opname: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Stok Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="barang-stok-opname-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
