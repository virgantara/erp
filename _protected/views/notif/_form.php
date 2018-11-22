<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Notif */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notif-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_from_id')->textInput() ?>

    <?= $form->field($model, 'user_to_id')->textInput() ?>

    <?= $form->field($model, 'is_read_user_from')->textInput() ?>

    <?= $form->field($model, 'is_read_user_to')->textInput() ?>

    <?= $form->field($model, 'is_hapus')->textInput() ?>

    <?= $form->field($model, 'created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
