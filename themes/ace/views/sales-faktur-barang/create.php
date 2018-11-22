<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesFakturBarang */

$this->title = 'Create Sales Faktur Barang';
$this->params['breadcrumbs'][] = ['label' => 'Sales Faktur Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-faktur-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
