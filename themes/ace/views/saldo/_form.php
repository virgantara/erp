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
$userLevel = Yii::$app->user->identity->access_role;    
            
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;
}

$listData=Perusahaan::getListPerusahaans();
 $bulans = [
    '01' => 'Januari',
    '02' => 'Februari',
    '03' => 'Maret',
    '04' => 'April',
    '05' => 'Mei',
    '06' => 'Juni',
    '07' => 'Juli',
    '08' => 'Agustus',
    '09' => 'September',
    '10' => 'Oktober',
    '11' => 'November',
    '12' => 'Desember',
];

$tahuns = [];

for($i = 2016 ;$i<=date('Y')+50;$i++)
    $tahuns[$i] = $i;

$model->bulan = !$model->isNewRecord ? $model->bulan : date('m');
$model->tahun = !$model->isNewRecord ? $model->tahun : date('Y');
?>

<div class="saldo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nilai_awal')->textInput() ?>

    <?= $form->field($model, 'nilai_akhir')->textInput() ?>

    <?= $form->field($model, 'bulan')->dropDownList($bulans) ?>

    <?= $form->field($model, 'tahun')->dropDownList($tahuns) ?>

     <?= $form->field($model, 'jenis')->dropDownList(['besar'=>'besar','kecil'=>'kecil']) ?>
     <?=$form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
