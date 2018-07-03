<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SalesSuplier */

$this->title = 'Create Sales Suplier';
$this->params['breadcrumbs'][] = ['label' => 'Sales Supliers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-suplier-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
