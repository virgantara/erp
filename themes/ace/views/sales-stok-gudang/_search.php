<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\SalesGudang;



$listDataGudang=SalesGudang::getListGudangs();
/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudangSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
<div class="col-lg-12">

    <?php $form = ActiveForm::begin([
        'action' => ['status'],
        'method' => 'get',
    ]); ?>

    <div class="col-lg-4">

    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..','class'=>'form-control']) ?>
</div>

<div class="col-lg-4">
    <?= $form->field($model, 'namaBarang') ?>
</div><div class="col-lg-2">
    <?= $form->field($model, 'durasiExp') ?>
</div>
    <div class="col-lg-2" ><br>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>