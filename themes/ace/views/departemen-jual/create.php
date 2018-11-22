<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DepartemenJual */

$this->title = 'Create Departemen Jual';
$this->params['breadcrumbs'][] = ['label' => 'Departemen Juals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="departemen-jual-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
