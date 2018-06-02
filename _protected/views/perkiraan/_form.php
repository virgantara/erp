<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Perkiraan */
/* @var $form yii\widgets\ActiveForm */
use yii\helpers\ArrayHelper;

use app\models\Perusahaan;
use app\models\Perkiraan;

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

$listParent=Perkiraan::find()->where(['perusahaan_id'=>$userPt])->orderBy(['kode'=>'ASC'])->all();

foreach($listParent as &$lib){
    $lib->nama = $lib->kode.' - '.$lib->nama;
}

$listDataParent=ArrayHelper::map($listParent,'id','nama');


?>

<div class="perkiraan-form">

    <?php $form = ActiveForm::begin(); ?>
     <?=$form->field($model, 'parent')->dropDownList($listDataParent, ['prompt'=>'..Pilih Akun..']);?>
    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

   
 	<?=$form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..','id'=>'id_perusahaan']);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
