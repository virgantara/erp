<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangRekap */

$this->title = 'Create Barang Rekap';
$this->params['breadcrumbs'][] = ['label' => 'Barang Rekaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-rekap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
