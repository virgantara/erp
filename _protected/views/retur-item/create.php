<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ReturItem */

$this->title = 'Create Retur Item';
$this->params['breadcrumbs'][] = ['label' => 'Retur Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
