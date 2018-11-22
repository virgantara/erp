<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrderItem */

$this->title = 'Update Request Order Item: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Order Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-order-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
