<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BarangDatang */

$this->title = 'Create Barang Datang';
$this->params['breadcrumbs'][] = ['label' => 'Barang Datangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barang-datang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
