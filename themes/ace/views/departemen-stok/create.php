<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSubStok */

$this->title = 'Create Perusahaan Sub Stok';
$this->params['breadcrumbs'][] = ['label' => 'Perusahaan Sub Stoks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perusahaan-sub-stok-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
