<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Perkiraan */

$this->title = 'Create Perkiraan';
$this->params['breadcrumbs'][] = ['label' => 'Perkiraans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perkiraan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
