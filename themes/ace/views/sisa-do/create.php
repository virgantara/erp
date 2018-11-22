<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SisaDo */

$this->title = 'Create Sisa Do';
$this->params['breadcrumbs'][] = ['label' => 'Sisa Dos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sisa-do-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
