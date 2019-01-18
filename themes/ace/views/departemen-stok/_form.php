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
       <?= $form->field($model, 'departemen_id')->dropDownList($listDepartment, ['prompt'=>'..Pilih Departemen..']); ?>
    
     <?= $form->field($model, 'barang_id')->widget(AutocompleteAjax::classname(), [
        'multiple' => false,
        'url' => ['sales-master-barang/ajax-search'],
        'options' => ['placeholder' => 'Cari Barang..']
    ]) ?>

    

    <?= $form->field($model, 'stok_akhir')->textInput() ?>

    <?= $form->field($model, 'stok_awal')->textInput() ?>


    <?= $form->field($model, 'bulan')->textInput() ?>

    <?= $form->field($model, 'tahun')->textInput() ?>

   <?= $form->field($model, 'tanggal')->widget(
        \yii\jui\DatePicker::className(),[
             'options' => ['placeholder' => 'Pilih tanggal  ...'],
            'dateFormat' => 'php:Y-m-d',
        ]
    ) ?>

    <?= $form->field($model, 'stok_bulan_lalu')->textInput() ?>

    <?= $form->field($model, 'stok')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
