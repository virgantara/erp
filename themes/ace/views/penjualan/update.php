<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */

$this->title = 'Update Penjualan: ' . $model->kode_penjualan;
$this->params['breadcrumbs'][] = ['label' => 'Penjualan', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->kode_penjualan, 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-update">

    
    <?= $this->render('_form_update', [
        'model' => $model,
        'cart' => $cart
    ]) ?>

</div>
