
   <?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use app\models\Perusahaan;

use kartik\depdrop\DepDrop;


$listData=Perusahaan::getListPerusahaans();

// $list=SalesGudang::find()->where(['jenis' => '3'])->all();
// $listSatuan=ArrayHelper::map($list,'id_satuan','nama');


use kartik\select2\Select2;
use yii\web\JsExpression;

$url = \yii\helpers\Url::to(['/perkiraan/ajax-perkiraan']);
?>

<div class="sales-master-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kode_barang')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nama_barang')->textInput(['maxlength' => true]) ?>

      <?= $form->field($model, 'id_satuan')->textInput() ?>
     

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

$this->registerJs(' 
    $(document).ready(function(){
         $(\'#id_perusahaan\').trigger(\'change\');
    });', \yii\web\View::POS_READY);

?>