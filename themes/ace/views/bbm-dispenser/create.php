<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BbmDispenser */

$this->title = 'Create Bbm Dispenser';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Dispensers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-dispenser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
