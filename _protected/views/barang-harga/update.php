<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BarangHarga */

$this->title = 'Update Barang Harga: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Hargas', 'url' => ['/sales-master-barang/view/','id'=>$_GET['barang_id']]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="barang-harga-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
