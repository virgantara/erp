<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangHarga */

$this->title = 'Create Barang Harga';
$this->params['breadcrumbs'][] = ['label' => 'Barang', 'url' => ['/sales-master-barang/view/','id'=>$_GET['barang_id']]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-harga-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
