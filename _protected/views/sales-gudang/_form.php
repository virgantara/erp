<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perusahaan;

use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */
/* @var $form yii\widgets\ActiveForm */

$list=Perusahaan::find()->where(['jenis' => '3'])->all();
$listData=ArrayHelper::map($list,'id_perusahaan','nama');

?>

<div class="sales-gudang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_perusahaan')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
