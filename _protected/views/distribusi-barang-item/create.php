<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarangItem */

$this->title = 'Create Distribusi Barang Item';
$this->params['breadcrumbs'][] = ['label' => 'Distribusi Barang Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribusi-barang-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
