<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSubStok */

$this->title = 'Update Perusahaan Sub Stok: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perusahaan Sub Stoks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="perusahaan-sub-stok-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
