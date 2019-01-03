
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\SalesGudang;

/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudang */
/* @var $form yii\widgets\ActiveForm */


$listDataGudang=SalesGudang::getListGudangs($model->isNewRecord);

?>

<div class="sales-stok-gudang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..']); ?>

       <?= $form->field($model, 'id_barang')->widget(\keygenqt\autocompleteAjax\AutocompleteAjax::classname(), [
	    'multiple' => false,
	    'url' => ['sales-master-barang/ajax-search'],
	    'options' => ['placeholder' => 'Cari Barang..']
	]) ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
