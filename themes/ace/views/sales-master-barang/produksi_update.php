<?php

use yii\helpers\Html;


$this->title = 'Update Data: ' . $model->id_barang;
$this->params['breadcrumbs'][] = ['label' => 'Produksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_barang, 'url' => ['view', 'id' => $model->id_barang]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-master-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('produksi_form', [
        'model' => $model,
    ]) ?>

</div>
