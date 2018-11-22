<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangLoss */

$this->title = 'Create Barang Loss';
$this->params['breadcrumbs'][] = ['label' => 'Barang Losses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-loss-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
