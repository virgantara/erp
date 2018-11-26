<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Retur */

$this->title = 'Create Retur';
$this->params['breadcrumbs'][] = ['label' => 'Returs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
