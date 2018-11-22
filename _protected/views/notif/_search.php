<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NotifSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notif-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?= $form->field($model, 'user_from_id') ?>

    <?= $form->field($model, 'user_to_id') ?>

    <?= $form->field($model, 'is_read_user_from') ?>

    <?php // echo $form->field($model, 'is_read_user_to') ?>

    <?php // echo $form->field($model, 'is_hapus') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
