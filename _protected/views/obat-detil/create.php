<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ObatDetil */

$this->title = 'Create Obat Detil';
$this->params['breadcrumbs'][] = ['label' => 'Obat Detils', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obat-detil-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
