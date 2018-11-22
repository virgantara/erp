<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BbmDispenserLog */

$this->title = 'Create Bbm Dispenser Log';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Dispenser Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-dispenser-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
