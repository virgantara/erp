<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\Url;
use yii\web\JsExpression;
use keygenqt\autocompleteAjax\AutocompleteAjax;
use yii\jui\AutoComplete;

use app\models\JenisResep;
$listJenisResep = \app\models\JenisResep::getListJenisReseps();

/* @var $this yii\web\View */
/* @var $model app\models\Penjualan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="penjualan-form">
<h3>Data Penjualan</h3>
    <div class="col-sm-6">
        <form class="form-horizontal">
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Rawat</label>

        <div class="col-sm-10">
            <select name="jenis_rawat" id="jenis_rawat">
                <option value="1">Rawat Jalan</option>
                <option value="2">Rawat Inap</option>
            </select>

            <input size="12" type="hidden" value="<?=\app\helpers\MyHelper::getRandomString();?>" id="kode_transaksi" />
            <button class="btn btn-info btn-sm" type="button" id="btn-resep-baru">
                <i class="ace-icon fa fa-plus bigger-110"></i>
                Resep Baru [F1]
            </button>
        </div>
           
    </div>
      <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Resep</label>
        <div class="col-sm-10">
          <?= Html::dropDownList('jenis_resep_id',!empty($_POST['jenis_resep_id']) ? $_POST['jenis_resep_id'] : $_POST['jenis_resep_id'],$listJenisResep, ['prompt'=>'..Pilih Jenis Resep..','id'=>'jenis_resep_id']);?>
          Tgl Resep : 
          <input name="tanggal"  type="text" id="tanggal" value="<?=date('Y-m-d');?>"/>
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pasien</label>

        <div class="col-sm-10">
            
             <input name="customer_id"  type="text" id="customer_id" /> 
             <input name="pasien_nama"  type="hidden" id="pasien_nama" /> 
              <input name="dokter_id"  type="hidden" id="dokter_id" />
                        <?php 
    AutoComplete::widget([
    'name' => 'customer_id',
    'id' => 'customer_id',
    'clientOptions' => [
         'source' =>new JsExpression('function(request, response) {
                        $.getJSON("'.Url::to(['api/ajax-pasien-daftar/']).'", {
                            term: request.term,
                            jenisrawat: $("#jenis_rawat").val()
                        }, response);
             }'),
    // 'source' => Url::to(['api/ajax-pasien-daftar/']),
        'autoFill'=>true,
        'minLength'=>'1',
        'select' => new JsExpression("function( event, ui ) {
            if(ui.item.id != 0){
                $('#pasien_id').val(ui.item.id);
                $('#pasien_nama').val(ui.item.namapx);

                $('#jenis_pasien').val(ui.item.namagol);
                $('#unit_pasien').val(ui.item.namaunit);
                $('#unit_id').val(ui.item.kodeunit);
                $('#kode_daftar').val(ui.item.nodaftar);
                $('#tgldaftar').datetextentry('set_date',ui.item.tgldaftar); 
                
    
            }
            
         }")
    ],
    'options' => [
        'size' => '40'
    ]
 ]); 
 ?>    

 Dokter :  <input name="dokter_nama"  type="text" id="dokter_nama" />

            <input name="pasien_id"  type="hidden" id="pasien_id"/>
             <input name="kode_daftar"  type="hidden" id="kode_daftar"/>
    <?php 
            AutoComplete::widget([
    'name' => 'dokter_nama',
    'id' => 'dokter_nama',
    'clientOptions' => [
    'source' => Url::to(['api/ajax-get-dokter']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#dokter_id').val(ui.item.id);
     }")],
    'options' => [
        // 'size' => '40'
    ]
 ]); 
 ?>
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jenis Px</label>

        <div class="col-sm-10">

            <input type="text" readonly id="jenis_pasien"/>
            Unit : 
             <?php 
    AutoComplete::widget([
    'name' => 'unit_pasien',
    'id' => 'unit_pasien',
    'clientOptions' => [
         'source' =>new JsExpression('function(request, response) {
                        $.getJSON("'.Url::to(['api/ajax-get-ref-unit/']).'", {
                            term: request.term,
                            tipe: $("#jenis_rawat").val()
                        }, response);
             }'),
    // 'source' => Url::to(['api/ajax-pasien-daftar/']),
        'autoFill'=>true,
        'minLength'=>'1',
        'select' => new JsExpression("function( event, ui ) {
            if(ui.item.id != 0)
                $('#unit_id').val(ui.item.id);
            

         }")
    ],
    'options' => [
        'size' => '40'
    ]
 ]); 
 ?>         <input type="text" id="unit_pasien"/>
            <input type="hidden" id="unit_id"/>
        </div>
    </div>
     
        </form>
   
</div>
<div class="col-sm-6">
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
    <button class="btn btn-success" id="btn-bayar"><i class="fa fa-money">&nbsp;</i>Bayar [F10]</button>
</div>
    <div class="col-sm-12">
        <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#profile4" id="click-nonracikan">Non-Racikan [F4]</a>
                </li>
                <li ">
                    <a data-toggle="tab" href="#home4" id="click-racikan">Racikan [F3]</a>
                </li>

                

               
            </ul>

            <div class="tab-content">
                 <div id="profile4" class="tab-pane  in active">
                    
 <?= $this->render('_non_racikan',[
    'model' => $model,
 ]);?>

    
                </div>
                <div id="home4" class="tab-pane">
<?= $this->render('_racikan', [
        'model' => $model,
    ]) ?>
                </div>

               

            </div>
        </div>
    </div><!-- /.col -->
   
</div>
<?php
$script = "


function popitup(url,label,pos) {
    var w = screen.width * 0.8;
    var h = 800;
    var left = pos == 1 ? screen.width - w : 0;
    var top = pos == 1 ? screen.height - h : 0;
    
    window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    
}


function resetNonracik(){
    $('#nama_barang').val('');
    $('#signa1_nonracik').val(0);
    $('#signa2_nonracik').val(0);
    $('#jumlah_hari_nonracik').val(0);
    $('#qty_nonracik').val(0);
    $('#jumlah_ke_apotik_nonracik').val(0);
}

function refreshTable(hsl){
    var row = '';
    $('#table-item > tbody').empty();
    var ii = 0, jj = 0;
    $.each(hsl.items,function(i,ret){
        
        if(ret.is_racikan=='1'){

            if(ii == 0){
                row += '<tr><td colspan=\"7\" style=\"text-align:left\">Racikan</td></tr>'
            }
            ii++;
            row += '<tr>';
            row += '<td>'+eval(ii)+'</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal+'</td>';
            row += '<td><a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\">Delete</a></td>';
            row += '</tr>';
        }

        else{
            if(jj == 0){
                row += '<tr><td colspan=\"7\" style=\"text-align:left\">Non-Racikan</td></tr>'
            }
            jj++;
            row += '<tr>';
            row += '<td>'+eval(jj)+'</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal+'</td>';
            row += '<td><a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\">Delete</a></td>';
            row += '</tr>';
        }
        
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
        url : '/cart/ajax-load-item',

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



$(document).on('keydown','.calc_kekuatan', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        

        var kekuatan = $('#kekuatan').val();
        var dosis_minta = $('#dosis_minta').val();
        var jml_racikan = $('#stok').val();

        kekuatan = isNaN(kekuatan) ? 0 : kekuatan;
        dosis_minta = isNaN(dosis_minta) ? 0 : dosis_minta;
        jml_racikan = isNaN(jml_racikan) ? 0 : jml_racikan;

        var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);
        
        $('#qty').val(hasil);
        $('#jumlah_ke_apotik').val(Math.ceil(hasil));
    }

    
});


$(document).on('keydown','.calc_qtynon', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        

        var signa1 = $('#signa1_nonracik').val();
        var signa2 = $('#signa2_nonracik').val();
        var jmlhari = $('#jumlah_hari_nonracik').val();

        signa1 = isNaN(signa1) ? 0 : signa1;
        signa2 = isNaN(signa2) ? 0 : signa2;
        jmlhari = isNaN(jmlhari) ? 0 : jmlhari;
        var qty = eval(signa1) * eval(signa2) * eval(jmlhari);

        $('#qty_nonracik').val(qty);
        $('#jumlah_ke_apotik_nonracik').val(qty);

    }

    
});

$(document).on('click','a.cart-delete', function(e) {

    var id = $(this).attr('data-item');
    var conf = confirm('Hapus item ini ? ');
    if(conf){
        $.ajax({
            type : 'POST',
            url : '/cart/ajax-delete',
            data : {dataItem:id},
            beforeSend: function(){

            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    refreshTable(hsl);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    }
});

$(document).ready(function(){

    $('input:text').focus(function(){
        $(this).css({'background-color' : '#A9F5E1'});
    });

    $('input:text').blur(function(){
        $(this).css({'background-color' : '#FFFFFF'});
    });

    $('#btn-resep-baru').click(function(){
        
        var conf = confirm('Buat Resep Baru?');

        if(conf){

            $('#signa1').focus();

            $.ajax({
              type : 'post',
              url : '/cart/ajax-generate-code',
              success : function(res){
                
                var res = $.parseJSON(res);
                
                $('#kode_transaksi').val(res);

                
              },
            });
        }
    });

    $(this).keydown(function(e){
        var key = e.keyCode;
        switch(key){
            case 112: //F1
                e.preventDefault();
                $('#btn-resep-baru').trigger('click');
            break;

            case 113: //F2
                e.preventDefault();
                $('#btn-simpan-item').trigger('click');
            break;
            case 114: // F3
                e.preventDefault();
                $('#click-racikan').trigger('click');
            break;
            case 115: // F4
                e.preventDefault();
                $('#click-nonracikan').trigger('click');
                $('#nama_barang').focus();
            break;

            case 117: // F6
                e.preventDefault();
                $('#btn-obat-baru').trigger('click');                
            break;

            case 119: // F8
                e.preventDefault();
                $('#signa1').focus();
                $('#nama_barang').focus();
            break;
            case 120: // F9
                e.preventDefault();
                $('#generate_kode').trigger('click');
            break;
            case 121: // F10
                e.preventDefault();
                $('#btn-bayar').trigger('click');
            break;
        }
        
    });


    $('#tanggal').datetextentry(); 
    $('#tgldaftar').datetextentry(); 

    $('#btn-bayar').click(function(){
        
        var kode_transaksi = $('#kode_transaksi').val();

        var pasien_id = $('#pasien_id').val();
        var dokter_id = $('#dokter_id').val();
        var jenis_rawat = $('#jenis_rawat').val();

        var obj = new Object;
        obj.kode_transaksi = kode_transaksi;
        obj.customer_id = pasien_id;
        obj.dokter_id = dokter_id;
        obj.kode_penjualan = kode_transaksi;
        obj.tanggal = $('#tanggal').val();
        obj.jenis_resep_id = $('#jenis_resep_id').val();
        obj.jenis_rawat = jenis_rawat;
        obj.kode_daftar = $('#kode_daftar').val();
        obj.dokter_nama = $('#dokter_nama').val();
        obj.unit_nama = $('#unit_pasien').val();
        obj.pasien_nama = $('#pasien_nama').val();
        obj.pasien_jenis = $('#jenis_pasien').val();
        obj.unit_id = $('#unit_id').val();

        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/cart/ajax-bayar',

            success : function(data){
                var data = $.parseJSON(data);
                if(data.code =='200'){
                    alert(data.message);
                    $.ajax({
                      type : 'post',
                      url : '/cart/ajax-generate-code',
                      success : function(res){
                        
                        var res = $.parseJSON(res);
                        
                        $('#kode_transaksi').val(res);

                        
                      },
                    });
                    var id = data.model_id;
                    refreshTable(data);
                    var urlResep = '/penjualan/print-resep?id='+id;
                    var urlPengantar = '/penjualan/print-pengantar?id='+id;
                    popitup(urlResep,'resep',0);
                    popitup(urlPengantar,'pengantar',1);    
                }

                else{
                    alert(data.message);
                }
                
            }

        });
    });

    $('#btn-input').click(function(e){
        e.preventDefault();
        var departemen_stok_id = $('#departemen_stok_id').val();
        var qty = $('#qty_nonracik').val();

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
        obj.harga = $('#harga_jual_nonracik').val();
        obj.subtotal = eval(obj.harga) * eval(obj.qty);
        obj.jumlah_ke_apotik = $('#jumlah_ke_apotik_nonracik').val();
        obj.signa1 = $('#signa1_nonracik').val();
        obj.signa2 = $('#signa2_nonracik').val();
        obj.jumlah_hari = $('#jumlah_hari_nonracik').val();

        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/cart/ajax-simpan-item',

            success : function(data){
                resetNonracik();
                $('#nama_barang').focus();

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