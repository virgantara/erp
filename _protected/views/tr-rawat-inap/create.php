<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInap */

$this->title = 'Create Tr Rawat Inap';
$this->params['breadcrumbs'][] = ['label' => 'Tr Rawat Inaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-rawat-inap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
