<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BarangLoss */

$this->title = 'Update Barang Loss: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Barang Losses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="barang-loss-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
