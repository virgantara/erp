<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use keygenqt\autocompleteAjax\AutocompleteAjax;
/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSubStok */
/* @var $form yii\widgets\ActiveForm */

$listDepartment = \app\models\Departemen::getListDepartemens();
?>

<div class="perusahaan-sub-stok-form">

    <?php $form = ActiveForm::begin(); ?>
       <?= $form->field($model, 'departemen_id')->dropDownList($listDepartment, ['prompt'=>'..Pilih Departemen..','disabled'=>'disabled']); ?>
    
     <?= $form->field($model, 'barang_id')->hiddenInput()->label(false); ?>
     <label>Barang</label>
    <?= Html::input('text','barang_nama',$model->barang->nama_barang,['class'=>'form-control','disabled'=>'disabled']) ?>

    <?= $form->field($model, 'stok_bulan_lalu')->textInput(['disabled'=>'disabled']) ?>

    <?= $form->field($model, 'stok')->textInput(['disabled'=>'disabled']) ?>
    <?= $form->field($model, 'stok_minimal')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
