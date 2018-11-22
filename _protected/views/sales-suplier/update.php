<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesSuplier */

$this->title = 'Update Sales Suplier: ' . $model->id_suplier;
$this->params['breadcrumbs'][] = ['label' => 'Sales Supliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_suplier, 'url' => ['view', 'id' => $model->id_suplier]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-suplier-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
