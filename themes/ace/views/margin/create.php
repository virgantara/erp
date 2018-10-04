<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Margin */

$this->title = 'Create Margin';
$this->params['breadcrumbs'][] = ['label' => 'Margins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="margin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
