<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PerusahaanSub */
/* @var $form yii\widgets\ActiveForm */

use app\models\Perusahaan;
use app\models\User;


/* @var $this yii\web\View */
/* @var $model app\models\SalesMasterBarang */
/* @var $form yii\widgets\ActiveForm */

$listData=Perusahaan::getListPerusahaans();
$listDataUser=User::getListUsers();
$where = [];

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;
}

?>

<div class="perusahaan-sub-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']); ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
