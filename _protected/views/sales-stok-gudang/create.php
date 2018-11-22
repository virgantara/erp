<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudang */

$this->title = 'Create Sales Stok Gudang';
$this->params['breadcrumbs'][] = ['label' => 'Sales Stok Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-stok-gudang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
