<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\JenisResep */

$this->title = 'Create Jenis Resep';
$this->params['breadcrumbs'][] = ['label' => 'Jenis Reseps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-resep-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
