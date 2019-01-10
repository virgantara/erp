<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProduksiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="produksi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barang_id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'kekuatan') ?>

    <?= $form->field($model, 'dosis_minta') ?>

    <?php // echo $form->field($model, 'jumlah_ke_apotik') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
