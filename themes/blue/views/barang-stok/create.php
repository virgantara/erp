<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangStok */

$this->title = 'Create Barang Stok';
$this->params['breadcrumbs'][] = ['label' => 'Barang Stoks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-stok-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
