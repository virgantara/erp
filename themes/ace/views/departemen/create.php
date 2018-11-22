<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSub */

$this->title = 'Create Cabang';
$this->params['breadcrumbs'][] = ['label' => 'Cabang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perusahaan-sub-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
