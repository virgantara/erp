<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = 'Update Request Order: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="request-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
