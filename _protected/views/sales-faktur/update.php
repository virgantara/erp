<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFaktur */

$this->title = 'Update Sales Faktur: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Sales Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_faktur, 'url' => ['view', 'id' => $model->id_faktur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-faktur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
