<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangStokOpname */

$this->title = 'Create Barang Stok Opname';
$this->params['breadcrumbs'][] = ['label' => 'Barang Stok Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-stok-opname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
