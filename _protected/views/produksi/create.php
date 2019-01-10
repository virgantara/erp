<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Produksi */

$this->title = 'Create Produksi';
$this->params['breadcrumbs'][] = ['label' => 'Produksis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produksi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
