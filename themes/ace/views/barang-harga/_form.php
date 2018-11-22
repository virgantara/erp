<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\SalesMasterBarang;
$listDataBarang=SalesMasterBarang::getListBarangs();

$option = [
    'prompt'=>'..Pilih Barang..',
];

if(!empty($model->barang_id)){ 
    $option = array_merge($option,['disabled'=>'disabled']);

}
?>

<div class="barang-harga-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barang_id')->dropDownList($listDataBarang, $option); ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
