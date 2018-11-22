<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BbmFakturItem */

$this->title = 'Create Bbm Faktur Item';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Faktur Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-faktur-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
