<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */
/* @var $form yii\widgets\ActiveForm */

$listDataDept=\app\models\Departemen::getListUnits();

?>

<div class="distribusi-barang-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Pilih tanggal distribusi ...'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    <?= $form->field($model, 'departemen_to_id')->dropDownList($listDataDept, ['prompt'=>'..Pilih Unit Tujuan..']);?>

    


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
