<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInap */

$this->title = 'Update Tr Rawat Inap: ' . $model->id_rawat_inap;
$this->params['breadcrumbs'][] = ['label' => 'Tr Rawat Inaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_rawat_inap, 'url' => ['view', 'id' => $model->id_rawat_inap]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tr-rawat-inap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
