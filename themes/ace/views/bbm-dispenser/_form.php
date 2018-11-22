<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\SalesMasterBarang;

use app\models\Perusahaan;


$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;   
}


$listData=Perusahaan::getListPerusahaans();



$listDataBarang = SalesMasterBarang::getListBarangs();
?>

<div class="bbm-dispenser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perusahaan_id')->dropDownList($listData); ?>

    <?= $form->field($model, 'barang_id')->dropDownList($listDataBarang, ['prompt'=>'..Pilih Barang..']); ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
