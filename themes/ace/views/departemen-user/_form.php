<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DepartemenUser */
/* @var $form yii\widgets\ActiveForm */

$listDataUser=\app\models\User::getListUsers();
$listDepartment = \app\models\Departemen::getListDepartemens();
?>

<div class="departemen-user-form">

    <?php $form = ActiveForm::begin(); ?>

	
       <?= $form->field($model, 'departemen_id')->dropDownList($listDepartment, ['prompt'=>'..Pilih Departemen..']); ?>
    <?= $form->field($model, 'user_id')->dropDownList($listDataUser, ['prompt'=>'..Pilih User..']); ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
