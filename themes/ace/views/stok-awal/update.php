<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StokAwal */

$this->title = 'Update Stok Awal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stok Awals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stok-awal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
