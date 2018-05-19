<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SatuanBarang */

$this->title = 'Update Satuan Barang: ' . $model->id_satuan;
$this->params['breadcrumbs'][] = ['label' => 'Satuan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_satuan, 'url' => ['view', 'id' => $model->id_satuan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="satuan-barang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
