<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SalesFaktur */

$this->title = 'Update Faktur: '.$model->no_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Sales Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View Faktur', 'url' => ['view', 'id' => $model->id_faktur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sales-faktur-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
