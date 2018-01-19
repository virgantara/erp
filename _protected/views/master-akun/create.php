<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\MasterAkun */

$this->title = 'Create Master Akun';
$this->params['breadcrumbs'][] = ['label' => 'Master Akuns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-akun-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
