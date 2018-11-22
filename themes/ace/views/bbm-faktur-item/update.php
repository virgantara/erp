<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BbmFakturItem */

$this->title = 'Update Bbm Faktur Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bbm Faktur Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bbm-faktur-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
