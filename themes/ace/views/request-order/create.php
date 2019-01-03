<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = 'BON Permintaan Obat';
$this->params['breadcrumbs'][] = ['label' => 'Request Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
	<div class="col-xs-12">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	</div>
</div>
