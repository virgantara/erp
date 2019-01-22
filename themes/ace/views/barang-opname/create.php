<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */

$this->title = 'Stok Opname';
$this->params['breadcrumbs'][] = ['label' => 'Stok Opname', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-opname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'list' => $list,
    ]) ?>

</div>
