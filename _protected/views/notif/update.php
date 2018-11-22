<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Notif */

$this->title = 'Update Notif: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Notifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="notif-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
