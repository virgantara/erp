<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


use yii\helpers\ArrayHelper;


use app\models\Perusahaan;


use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\SalesSuplier */
/* @var $form yii\widgets\ActiveForm */


$session = Yii::$app->session;
$userPt = '';
    
$where = [];    
if($session->isActive)
{
    $userLevel = $session->get('level');    
    
    if($userLevel == 'admSalesCab'){
        $userPt = $session->get('perusahaan');
        $model->id_perusahaan = $userPt;
        $where = [
            'id_perusahaan' => $userPt
        ];
    }
}

$list=Perusahaan::find()->where($where)->all();
$listData=ArrayHelper::map($list,'id_perusahaan','nama');

?>

<div class="sales-suplier-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_perusahaan')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']); ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
