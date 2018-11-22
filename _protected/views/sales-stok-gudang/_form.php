<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\SalesMasterBarang;
use app\models\SalesGudang;

/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudang */
/* @var $form yii\widgets\ActiveForm */


$listDataGudang=SalesGudang::getListGudangs($model->isNewRecord);
$listDataBarang=SalesMasterBarang::getListBarangs();

?>

<div class="sales-stok-gudang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..']); ?>

    <?= $form->field($model, 'id_barang')->dropDownList($listDataBarang, ['prompt'=>'..Pilih Barang..']); ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
