<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BbmJual */

$this->title = 'Create Bbm Jual';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Juals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bbm-jual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
