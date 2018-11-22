<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DepartemenUser */

$this->title = 'Create Departemen User';
$this->params['breadcrumbs'][] = ['label' => 'Departemen Users', 'url' => ['/departemen/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departemen-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
