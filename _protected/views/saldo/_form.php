<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\Perusahaan;

/* @var $this yii\web\View */
/* @var $model app\models\Saldo */
/* @var $form yii\widgets\ActiveForm */

 $session = Yii::$app->session;
$userPt = '';
    
$where = [];
if($session->isActive)
{
    $userLevel = $session->get('level');    
    
    if($userLevel == 'admin'){
        $userPt = $session->get('perusahaan');
        $where = [
            'id_perusahaan' => $userPt
        ];
    }
}

$list=Perusahaan::find()->where($where)->all();
$listData=ArrayHelper::map($list,'id_perusahaan','nama');

?>

<div class="saldo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nilai_awal')->textInput() ?>

    <?= $form->field($model, 'nilai_akhir')->textInput() ?>

    <?= $form->field($model, 'bulan')->textInput() ?>

    <?= $form->field($model, 'tahun')->textInput() ?>

     <?= $form->field($model, 'jenis')->dropDownList(['besar'=>'besar','kecil'=>'kecil']) ?>
     <?=$form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
