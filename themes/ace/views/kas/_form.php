<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Kas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kwitansi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penanggung_jawab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tanggal')->widget(
        DatePicker::className(),[
            'name' => 'tanggal', 
            'value' => date('d-M-Y', strtotime('0 days')),
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'dd-M-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    
    <?= $form->field($model, 'kas_keluar')->textInput() ?>

    <?= $form->field($model, 'kas_masuk')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
