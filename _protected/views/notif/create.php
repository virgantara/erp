<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Notif */

$this->title = 'Create Notif';
$this->params['breadcrumbs'][] = ['label' => 'Notifs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notif-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
