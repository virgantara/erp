<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SatuanBarang */

$this->title = 'Create Satuan Barang';
$this->params['breadcrumbs'][] = ['label' => 'Satuan Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="satuan-barang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
