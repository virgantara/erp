<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;

use app\models\SalesStokGudang;

use kartik\depdrop\DepDrop;

$listData = SalesStokGudang::getListStokGudang();
?>

<div class="request-order-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ro_id')->textInput() ?>

   <?= $form->field($model, 'stok_id')->dropDownList($listData, ['prompt'=>'..Pilih Gudang..','id'=>'stok_id']); ?>

     <?php
     echo $form->field($model, 'item_id')->widget(DepDrop::classname(), [
        'options'=>['id'=>'item_id'],
        'pluginOptions'=>[
            'depends'=>['stok_id'],
            'placeholder'=>'..Pilih Item..',
            'url'=>Url::to(['/sales-stok-gudang/get-barang-stok'])
        ]
    ]);
     ?>

    <?= $form->field($model, 'jumlah_minta')->textInput() ?>

    <?php

     if(Yii::$app->user->can('gudang')) 
         echo  $form->field($model, 'jumlah_beri')->textInput();
?>
    <?= $form->field($model, 'satuan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS

jQuery(function($){
    $('#stok_id').trigger('change');

});

JS;
$this->registerJs($script);
?>

