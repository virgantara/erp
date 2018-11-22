<?php

use yii\helpers\Html;


$this->title = 'Create Sales Barang';
$this->params['breadcrumbs'][] = ['label' => 'Sales Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
