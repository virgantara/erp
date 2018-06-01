<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Perusahaan;
use kartik\time\TimePicker;


$listData=Perusahaan::getListPerusahaans();

$userLevel = Yii::$app->user->identity->access_role;    
        
if($userLevel != 'admin'){
    $userPt = Yii::$app->user->identity->perusahaan_id;
    $model->perusahaan_id = $userPt;

}

?>

<div class="shift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jam_mulai',['options'=>['class'=>'form-group col-xs-6']])->widget(TimePicker::className(),[
    	'options' => ['placeholder' => 'Select start operating time ...'],
		'pluginOptions' => [
			'showSeconds' => true,
			'secondStep' => 10,	
	        'showMeridian' => false,
	        'minuteStep' => 5,
  
		]
    ]) ?>

    <?= $form->field($model, 'jam_selesai',['options'=>['class'=>'form-group col-xs-6']])->widget(TimePicker::className(),[
    	'options' => ['placeholder' => 'Select end operating time ...'],
			'pluginOptions' => [
				'showSeconds' => true,
				'secondStep' => 10,
				  'showMeridian' => false,
		        'minuteStep' => 5,
			]
    ]) ?>

    <?= $form->field($model, 'perusahaan_id')->dropDownList($listData, ['prompt'=>'..Pilih Perusahaan..']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
