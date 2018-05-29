<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BbmFaktur */

$this->title = 'Create Bbm Faktur';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-faktur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
