<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */

$this->title = 'Create Sales Gudang';
$this->params['breadcrumbs'][] = ['label' => 'Sales Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-gudang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
