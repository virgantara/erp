<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MasterAkun */

$this->title = 'Update Master Akun: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Master Akuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kode_akun, 'url' => ['view', 'id' => $model->kode_akun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-akun-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
