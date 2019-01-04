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
<h3>Data Penjualan</h3>
    <table width="100%" >
         <tr >
            <td width="8%">Kode TRX</td>
            <td width="2%">:</td>
            <td  width="35%">  <input type="text" value="<?=\app\helpers\MyHelper::getRandomString();?>" id="kode_transaksi" /></td>
            <td  width="50%" rowspan="3" style="vertical-align: top;height: 140px">
                <h2>Total Biaya :</h2>
                <h1 id="total_biaya" style="font-size: 48px"></h1>
            </td>
        </tr>
        <tr >
            <td>Tanggal Transaksi</td>
            <td>:</td>
            <td>  <input name="tanggal"  type="text" id="tanggal" /></td>
        </tr>
        <tr>
            <td >Customer</td>
            <td >:</td>
            <td><?= AutoComplete::widget([
    'name' => 'customer_id',
    'id' => 'customer_id',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-stok-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        
     }")],
    'options' => [
        'size' => '40'
    ]
 ]); ?></td>
        </tr>
    </table>

   <h3>Data Barang</h3>
    <div class="row">
        <div class="col-xs-3">
            Barang<br>
            <input type="hidden" id="departemen_stok_id"/>
               <?php 
    // $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
   
echo AutoComplete::widget([
    'name' => 'nama_barang',
    'id' => 'nama_barang',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-stok-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#departemen_stok_id').val(ui.item.dept_stok_id);
     }")],
    'options' => [
        'size' => '40'
    ]
 ]);
    ?>

   
        </div>
        <div class="col-xs-3">
             Qty<br><input type="number" name="qty" id="qty" />&nbsp;<button id="btn-input" class="btn btn-info btn-sm">Pilih</button>
        </div>
    </div>

    <div class="row" style="padding-top:10px">
        <div class="col-xs-12">
            <table class="table table-striped table-bordered" id="table-item">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th style="text-align: center;">Harga</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: center;">Subtotal</th>
                        <th style="text-align: center;">Option</th>                
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$script = "

function refreshTable(hsl){
    var row = '';
    $('#table-item > tbody').empty();

    $.each(hsl.items,function(i,ret){
        row += '<tr>';
        row += '<td>'+eval(i+1)+'</td>';
        row += '<td>'+ret.kode+'</td>';
        row += '<td>'+ret.nama+'</td>';
        row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
        row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
        row += '<td style=\"text-align:right\">'+ret.subtotal+'</td>';
        row += '<td><a href=\"javascript:void(0)\">Delete</a></td>';
        row += '</tr>';
    });

    row += '<tr>';
    row += '<td colspan=\"5\" style=\"text-align:right\"><strong>Total Biaya</strong></td>';
    row += '<td style=\"text-align:right\"><strong>'+hsl.total+'</strong></td>';
    row += '<td></td>';
    row += '</tr>';

    $('#total_biaya').html(hsl.total);

    $('#table-item').append(row);
}

function loadItem(kode_trx){
   

    if(kode_trx == ''){
        alert('Kode Transaksi tidak boleh kosong');
        return;
    }

    obj = new Object;
    obj.kode_transaksi = kode_trx;
    $.ajax({
        type : 'POST',
        data : {dataItem:obj},
        url : '/penjualan/ajax-load-item',

        success : function(data){
            var hsl = jQuery.parseJSON(data);
            refreshTable(hsl);
          
        }
    });

}

$(document).on('keydown','#kode_transaksi', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        loadItem($(this).val());


    }
});

$(document).ready(function(){



    $('#tanggal').datetextentry(); 

    $('#btn-input').click(function(){

        var departemen_stok_id = $('#departemen_stok_id').val();
        var qty = $('#qty').val();

        if(departemen_stok_id == ''){
            alert('Data Obat tidak boleh kosong');
            return;
        }

        if(qty == ''){
            alert('Jumlah / Qty tidak boleh kosong');
            return;
        }

        obj = new Object;
        obj.departemen_stok_id = departemen_stok_id;
        obj.qty = qty;
        obj.kode_transaksi = $('#kode_transaksi').val();
        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/penjualan/ajax-input-item',

            success : function(data){
                var hsl = jQuery.parseJSON(data);
                refreshTable(hsl);
            }
        });
    });
});

$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        var inputs = $(this).closest('.penjualan-form').find(':input:visible');
              
        inputs.eq( inputs.index(this)+ 1 ).focus().select();
        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 10);


    }
});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>