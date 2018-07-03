<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */

$this->title = 'Update Sales Gudang: ' . $model->id_gudang;
$this->params['breadcrumbs'][] = ['label' => 'Sales Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_gudang, 'url' => ['view', 'id' => $model->id_gudang]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-gudang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
