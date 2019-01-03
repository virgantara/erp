<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\web\JsExpression;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-form">

    <div class="row">
        <div class="col-xs-3">
            Barang<br>
               <?php 
    $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
   
echo AutoComplete::widget([
    'name' => 'barang_id',
    'id' => 'barang_id',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-stok-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        console.log(ui.item.id);
     }")],
    'options' => [
        'size' => '40'
    ]
 ]);
    ?>

   
        </div>
        <div class="col-xs-3">
             Qty<br><input type="number" name="qty" id="qty" />&nbsp;<button class="btn btn-info btn-sm">Pilih</button>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped">
                
                
            </table>
        </div>
    </div>
</div>
