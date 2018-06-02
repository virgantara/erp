<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Neraca */

$this->title = 'Create Neraca';
$this->params['breadcrumbs'][] = ['label' => 'Neracas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neraca-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
