<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Perkiraan */

$this->title = 'Update Perkiraan: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perkiraans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="perkiraan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
