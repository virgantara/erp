<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesBarang */

$this->title = 'Create Sales Barang';
$this->params['breadcrumbs'][] = ['label' => 'Sales Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
