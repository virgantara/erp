<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudang */

$this->title = 'Update Sales Stok Gudang: ' . $model->id_stok;
$this->params['breadcrumbs'][] = ['label' => 'Sales Stok Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_stok, 'url' => ['view', 'id' => $model->id_stok]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-stok-gudang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
