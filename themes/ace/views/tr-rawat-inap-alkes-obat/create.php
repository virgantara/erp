<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInapAlkesObat */

$this->title = 'Data Pasien';
$this->params['breadcrumbs'][] = ['label' => 'Tr Rawat Inap Alkes Obats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-rawat-inap-alkes-obat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'rawatInap' => $rawatInap,
        'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    ]) ?>

</div>
