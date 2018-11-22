<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Piutang */

$this->title = 'Create Piutang';
$this->params['breadcrumbs'][] = ['label' => 'Piutangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="piutang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
