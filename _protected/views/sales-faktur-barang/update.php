<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFakturBarang */

$this->title = 'Update Sales Faktur Barang: ' . $model->id_faktur_barang;
$this->params['breadcrumbs'][] = ['label' => 'Sales Faktur Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_faktur_barang, 'url' => ['view', 'id' => $model->id_faktur_barang]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-faktur-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
