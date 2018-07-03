<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Saldo */

$this->title = 'Update Saldo: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Saldos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="saldo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
