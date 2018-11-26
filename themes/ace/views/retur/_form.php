<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use keygenqt\autocompleteAjax\AutocompleteAjax;
?>

<div class="retur-form">

    <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'faktur_id')->widget(AutocompleteAjax::classname(), [
    'multiple' => false,
    'url' => ['sales-faktur/ajax-search-faktur'],
    'options' => ['placeholder' => 'Cari no faktur.']
]) ?>

	<?= $form->field($model, 'suplier_id')->widget(AutocompleteAjax::classname(), [
    'multiple' => false,
    'url' => ['sales-suplier/ajax-search'],
    'options' => ['placeholder' => 'Cari Suplier.']
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
