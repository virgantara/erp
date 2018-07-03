<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesIncome */

$this->title = 'Update Penjualan: ' . $model->id_sales;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sales, 'url' => ['view', 'id' => $model->id_sales]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-income-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
