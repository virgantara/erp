<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\StokAwal */

$this->title = 'Create Stok Awal';
$this->params['breadcrumbs'][] = ['label' => 'Stok Awals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stok-awal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
