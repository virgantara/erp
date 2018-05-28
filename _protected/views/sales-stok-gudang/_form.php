<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\SalesBarang;
use app\models\SalesGudang;

/* @var $this yii\web\View */
/* @var $model app\models\SalesStokGudang */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$userPt = '';
    
$where = [];    
if($session->isActive)
{
    $userLevel = $session->get('level');    
    
    if($userLevel == 'admSalesCab'){
        $userPt = $session->get('perusahaan');
        
        $where = [
            'id_perusahaan' => $userPt
        ];
    }
}

$listGudang=SalesGudang::find()->where($where)->all();
$listDataGudang=ArrayHelper::map($listGudang,'id_gudang','nama');

$listBarang=SalesBarang::find()->where($where)->all();
$listDataBarang=ArrayHelper::map($listBarang,'id_barang','nama_barang');

?>

<div class="sales-stok-gudang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..']); ?>

    <?= $form->field($model, 'id_barang')->dropDownList($listDataBarang, ['prompt'=>'..Pilih Barang..']); ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
