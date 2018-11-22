<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Piutang */

$this->title = 'Update Piutang: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Piutangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="piutang-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
