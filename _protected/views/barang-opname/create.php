<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */

$this->title = 'Create Barang Opname';
$this->params['breadcrumbs'][] = ['label' => 'Barang Opnames', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-opname-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
