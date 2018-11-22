<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perusahaan;

use kartik\checkbox\CheckboxX;

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->id_perusahaan = $userPt;

}

/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */
/* @var $form yii\widgets\ActiveForm */


$listData=Perusahaan::getListPerusahaans();

?>

<div class="sales-gudang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kapasitas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_sejenis')->widget(CheckboxX::className(),[

        'pluginOptions' => [
            'threeState' => true,
            'size' => 'lg'
        ]

    ]); ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_perusahaan')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


