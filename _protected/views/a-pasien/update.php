<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\APasien */

$this->title = 'Update Apasien: ' . $model->NoMedrec;
$this->params['breadcrumbs'][] = ['label' => 'Apasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NoMedrec, 'url' => ['view', 'id' => $model->NoMedrec]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="apasien-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
