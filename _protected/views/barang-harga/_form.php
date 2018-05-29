<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;

use app\models\SalesBarang;


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

$listBarang=SalesBarang::find()->where($where)->all();
$listDataBarang=ArrayHelper::map($listBarang,'id_barang','nama_barang');

$option = [
    'prompt'=>'..Pilih Barang..',
];

if(!empty($model->barang_id)){ 
    $option = array_merge($option,['disabled'=>'disabled']);

}
?>

<div class="barang-harga-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barang_id')->dropDownList($listDataBarang, $option); ?>

    <?= $form->field($model, 'harga_beli')->textInput() ?>

    <?= $form->field($model, 'harga_jual')->textInput() ?>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
