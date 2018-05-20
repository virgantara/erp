<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Perusahaan;

use yii\helpers\ArrayHelper;

$session = Yii::$app->session;
$userPt = '';
    
$where = [
    'jenis' => '3'
];    
if($session->isActive)
{
    $userLevel = $session->get('level');    
    
    if($userLevel == 'admin_cabang'){
        $userPt = $session->get('perusahaan');
        $model->id_perusahaan = $userPt;
        $where = [
            'id_perusahaan' => $userPt
        ];
    }
}

/* @var $this yii\web\View */
/* @var $model app\models\SalesGudang */
/* @var $form yii\widgets\ActiveForm */

$list=Perusahaan::find()->where($where)->all();
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


