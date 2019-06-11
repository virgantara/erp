<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MenuLayout */

$this->title = 'Create Menu Layout';
$this->params['breadcrumbs'][] = ['label' => 'Menu Layouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-layout-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'listParent' => $listParent
    ]) ?>

</div>
