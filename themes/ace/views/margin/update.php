<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Margin */

$this->title = 'Update Margin: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Margins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="margin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
