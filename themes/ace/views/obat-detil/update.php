<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ObatDetil */

$this->title = 'Update Obat Detil: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Obat Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="obat-detil-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
