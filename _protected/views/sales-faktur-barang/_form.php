<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


use yii\helpers\ArrayHelper;

use app\models\SatuanBarang;
use app\models\SalesBarang;
use app\models\SalesGudang;

use kartik\depdrop\DepDrop;


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

$list=SatuanBarang::find()->where(['jenis' => '3'])->all();
$listSatuan=ArrayHelper::map($list,'id_satuan','nama');


$list=SalesGudang::find()->where($where)->all();
$listDataGudang=ArrayHelper::map($list,'id_gudang','nama');

?>

<div class="sales-faktur-barang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_faktur')->textInput() ?>
    <?= $form->field($model, 'id_gudang')->dropDownList($listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang']); ?>
      <?php
     echo $form->field($model, 'id_barang')->widget(DepDrop::classname(), [
        'options'=>['id'=>'id_barang'],
        'pluginOptions'=>[
            'depends'=>['id_gudang'],
            'placeholder'=>'..Pilih Barang..',
            'url'=>Url::to(['/sales-gudang/get-barang'])
        ]
    ]);
     ?>
    <?= $form->field($model, 'id_satuan')->dropDownList($listSatuan, ['prompt'=>'..Pilih Satuan..']); ?>


    <?= $form->field($model, 'jumlah')->textInput() ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
