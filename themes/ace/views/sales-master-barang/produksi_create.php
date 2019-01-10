<?php

use yii\helpers\Html;


$this->title = 'Form Barang Produksi';
$this->params['breadcrumbs'][] = ['label' => 'Produksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('produksi_form', [
        'model' => $model,
    ]) ?>

</div>
