<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BbmDispenserLog */

$this->title = 'Update Bbm Dispenser Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bbm Dispenser Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bbm-dispenser-log-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
