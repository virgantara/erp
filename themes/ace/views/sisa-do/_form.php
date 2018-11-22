<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\SalesMasterBarang;
use app\models\Perusahaan;
use kartik\date\DatePicker;
use app\models\SalesGudang;


$listDataBarang=SalesMasterBarang::getListBarangs();
$listData=Perusahaan::getListPerusahaans();
$listGudang = SalesGudang::getListGudangs();
?>


<div class="sisa-do-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'perusahaan_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']);?>
    <?= $form->field($model, 'barang_id',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->dropDownList($listDataBarang, ['prompt'=>'.. Pilih BBM','id'=>'barang_id']); ?>
   <?= $form->field($model, 'tanggal',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->widget(
        DatePicker::className(),[
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Pilih tanggal transaksi ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    <?= $form->field($model, 'jumlah',['options'=>['class'=>'form-group col-xs-12 col-lg-6']])->textInput(['type'=>'number']) ?>

    <div class="form-group row col-lg-12">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
