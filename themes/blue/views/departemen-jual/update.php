<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DepartemenJual */

$this->title = 'Update Departemen Jual: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Departemen Juals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="departemen-jual-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
