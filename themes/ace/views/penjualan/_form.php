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
$rawat = [1 => 'Rawat Jalan',2=>'Rawat Inap'];
?>

<style type="text/css">
    .spinner {
  width: 50px;
  height: 40px;
  text-align: center;
  font-size: 10px;
}

.spinner > div {
  background-color: #333;
  height: 100%;
  width: 6px;
  display: inline-block;
  
  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
  animation: sk-stretchdelay 1.2s infinite ease-in-out;
}

.spinner .rect2 {
  -webkit-animation-delay: -1.1s;
  animation-delay: -1.1s;
}

.spinner .rect3 {
  -webkit-animation-delay: -1.0s;
  animation-delay: -1.0s;
}

.spinner .rect4 {
  -webkit-animation-delay: -0.9s;
  animation-delay: -0.9s;
}

.spinner .rect5 {
  -webkit-animation-delay: -0.8s;
  animation-delay: -0.8s;
}

@-webkit-keyframes sk-stretchdelay {
  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
  20% { -webkit-transform: scaleY(1.0) }
}

@keyframes sk-stretchdelay {
  0%, 40%, 100% { 
    transform: scaleY(0.4);
    -webkit-transform: scaleY(0.4);
  }  20% { 
    transform: scaleY(1.0);
    -webkit-transform: scaleY(1.0);
  }
}
</style>
<div class="penjualan-form">
<h3>Data Penjualan <?=$rawat[$jenis_rawat];?></h3>
<div class="row">
    <div class="col-sm-4">
        <form class="form-horizontal">
    <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Cari Pasien/RM</label>

        <div class="col-sm-10">
            
             <input name="customer_id" class="form-control"  type="text" id="customer_id" size="10" style="width:200px" /> 
             <div class="spinner" id="loading" style="display: none;">
                  <div class="rect1"></div>
                  <div class="rect2"></div>
                  <div class="rect3"></div>
                  <div class="rect4"></div>
                  <div class="rect5"></div>
                </div>
             <!-- <input name="pasien_nama"  type="hidden" id="pasien_nama" />  -->
              <input name="dokter_id"  type="hidden" id="dokter_id" />
              <input name="id_rawat_inap"  type="hidden" id="id_rawat_inap" />
              
                        <?php 
 //    AutoComplete::widget([
 //    'name' => 'customer_id',
 //    'id' => 'customer_id',
 //    'clientOptions' => [
 //         'source' =>new JsExpression('function(request, response) {
 //                        $.getJSON("'.Url::to(['api/ajax-pasien-daftar/']).'", {
 //                            term: request.term,
 //                            jenis_rawat: $("#jenis_rawat").val()
 //                        }, response);
 //             }'),
 //    // 'source' => Url::to(['api/ajax-pasien-daftar/']),
 //        'autoFill'=>true,
 //        'minLength'=>'1',
 //        'select' => new JsExpression("function( event, ui ) {
 //            if(ui.item.id != 0){
 //                $('#pasien_id').val(ui.item.id);
 //                $('#pasien_nama').val(ui.item.namapx);
 //                loadItemHistory(ui.item.id);
 //                $('#jenis_pasien').val(ui.item.namagol);
 //                $('#jenis_resep_nama').val(ui.item.namagol);
 //                $('#jenis_resep_id').val(ui.item.jenispx);
 //                $('#unit_pasien').val(ui.item.namaunit);
 //                $('#unit_id').val(ui.item.kodeunit);
 //                $('#kode_daftar').val(ui.item.nodaftar);
 //                $('#id_rawat_inap').val(ui.item.id_rawat_inap);
 //                $('#tgldaftar').datetextentry('set_date',ui.item.tgldaftar); 
 //                $('#dokter_id').val(ui.item.id_dokter);
 //                $('#dokter_nama').val(ui.item.nama_dokter);
 //            }
            
 //         }")
 //    ],
 //    'options' => [
 //        'size' => '40'
 //    ]
 // ]); 
 ?>    
 <input name="pasien_id"  type="hidden" id="pasien_id" value="0"/>
             <input name="kode_daftar"  type="hidden" id="kode_daftar"/>
    
          
  
        </div>
    </div>
       <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama Pasien</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="pasien_nama" name="pasien_nama"/>
            
        </div>
    </div>
     <div class="form-group col-xs-12 col-lg-12">
          
           
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tgl Resep</label>

        <div class="col-sm-10">
            <input name="tanggal"  type="text" id="tanggal" value="<?=date('Y-m-d');?>"/>
        </div>
    </div>
     <div class="form-group col-xs-12 col-lg-12">
          
           
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Unit</label>

        <div class="col-sm-10">
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
 ?>         <input type="text" class="form-control" id="unit_pasien"/>
            <input type="hidden" id="unit_id"/>
          

            <input size="12" type="hidden" value="<?=\app\helpers\MyHelper::getRandomString();?>" id="kode_transaksi" />
              
           <!--  <button class="btn btn-info btn-sm" type="button" id="btn-resep-baru">
                <i class="ace-icon fa fa-plus bigger-110"></i>
                Resep Baru [F1]
            </button> -->
        </div>
           
    </div>
    <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1">Dokter</label>
        <div class="col-sm-10">
            <input name="dokter_nama" class="form-control"  type="text" id="dokter_nama" />

           
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
    <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Px</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="jenis_pasien"/>
            <input type="hidden" class="form-control" id="jenis_rawat" value="<?=$jenis_rawat;?>"/>
        
        </div>
    </div>
      <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Resep</label>
        <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_resep_nama"/>
              <input type="hidden" id="jenis_resep_id" value="<?php !empty($_POST['jenis_resep_id']) ? $_POST['jenis_resep_id'] : $_POST['jenis_resep_id'];?>"/>
          <?php 

           AutoComplete::widget([
    'name' => 'jenis_resep_nama',
    'id' => 'jenis_resep_nama',
    'clientOptions' => [

        'source' => Url::to(['jenis-resep/ajax-jenis-resep/']),
        'autoFill'=>true,
        'minLength'=>'1',
        'select' => new JsExpression("function( event, ui ) {
            $('#jenis_resep_id').val(ui.item.id);
         }")
    ],
    'options' => [
        'size' => '40'
    ]
 ]); 
          ?>

         
        </div>
    </div>
    
     
        </form>
   
</div>
<div class="col-sm-8">
     <div class="tabbable">
            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                <li class="active">
                    <a data-toggle="tab" href="#profile4" id="click-nonracikan">Non-Racikan [F4]</a>
                </li>
                <li >
                    <a data-toggle="tab" href="#home4" id="click-racikan">Racikan [F3]</a>
                </li>
                <li >
                    <a data-toggle="tab" href="#riwayat" id="click-riwayat">Riwayat Obat</a>
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

                <div id="riwayat" class="tab-pane">
                    <table id="tabel_riwayat" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Resep</th>
                                <th>Tanggal</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Racikan<br>Non-Racikan</th>
                                <th style="text-align: center;">Signa 1</th>
                                <th style="text-align: center;">Signa 2</th>
                                <th style="text-align: center;">Harga</th>
                                <th style="text-align: center;">Qty</th>
                                <th style="text-align: center;">Subtotal</th>
                                <th style="text-align: center;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
</div>
</div>
    <div class="col-sm-12">
<input type="hidden" id="cart_id"/>
<input type="hidden" id="departemen_stok_id_update"/>
<table class="table table-striped table-bordered" id="table-item">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th style="text-align: center;">Signa 1</th>
                <th style="text-align: center;">Signa 2</th>
                <th style="text-align: center;">Harga</th>
                <th style="text-align: center;">Qty</th>
                
                <th style="text-align: center;">Subtotal</th>
                <th style="text-align: center;">Option</th>                
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
    <button class="btn btn-success" id="btn-bayar"><i class="fa fa-money">&nbsp;</i>Simpan & Cetak [F10]</button>
       
    </div><!-- /.col -->


<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Cart Non-Racikan</h2>',
    'toggleButton' => ['label' => '','id'=>'modal-update-cart','style'=>'display:none'],
    
]);

?>

<?= $this->render('_non_racikan_update', [
        'model' => $model,
    ]) ?>
<?php

\yii\bootstrap\Modal::end();
?>


<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Cart Racikan</h2>',
    'size' => 'modal-lg',
    'toggleButton' => ['label' => '','id'=>'modal-update-racik-cart','style'=>'display:none'],
    
]);
?>
<?= $this->render('_racikan_update', [
        'model' => $model,
    ]) ?>
<?php

\yii\bootstrap\Modal::end();
?>
   
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

function refreshTableHistory(hsl){
    var row = '';

    $('#tabel_riwayat > tbody').empty();
    
    $.each(hsl.items,function(i,ret){
        row += '<tr>';
        row += '<td>'+ret.counter+'</td>';
        row += '<td>'+ret.no_resep+'</td>';
        row += '<td>'+ret.tgl_resep+'</td>';
        if(ret.is_racikan=='1'){

            row += '<td>Racikan</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
            row += '<td style=\"text-align:center\">'+ret.signa1+'</td>';
            row += '<td style=\"text-align:center\">'+ret.signa2+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal+'</td>';
            row += '<td style=\"text-align:right\">'+ret.total_label+'</td>';
        
        }

        else{
          
            row += '<td>Non-Racikan</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
             row += '<td style=\"text-align:center\">'+ret.signa1+'</td>';
            row += '<td style=\"text-align:center\">'+ret.signa2+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal+'</td>';
            row += '<td style=\"text-align:right\">'+ret.total_label+'</td>';
        }
        row += '</tr>';
        

        
    });

    $('#tabel_riwayat').append(row);
}

function loadItemHistory(customer_id){
   

    if(customer_id == ''){
        alert('Kode Pasien tidak boleh kosong');
        return;
    }

    obj = new Object;
    obj.customer_id = parseInt(customer_id,10);
    $.ajax({
        type : 'POST',
        data : {dataItem:obj},
        url : '/penjualan/ajax-load-item-history',

        success : function(data){
            var hsl = jQuery.parseJSON(data);
            refreshTableHistory(hsl);
          
        }
    });

}

function refreshTable(hsl){
    var row = '';
    $('#table-item > tbody').empty();
    var ii = 0, jj = 0;
    $.each(hsl.items,function(i,ret){
        
        if(ret.is_racikan=='1'){

            if(ii == 0){
                row += '<tr><td colspan=\"9\" style=\"text-align:left\">Racikan</td></tr>'
            }
            ii++;
            row += '<tr>';
            row += '<td>'+eval(ii)+'</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
            row += '<td style=\"text-align:right\">'+ret.signa1+'</td>';
            row += '<td style=\"text-align:right\">'+ret.signa2+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty_bulat+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal_bulat+'</td>';
            row += '<td><a href=\"javascript:void(0)\" class=\"cart-update\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-pencil\"></i></a>';
            row += '&nbsp;<a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-trash\"></i></a></td>';
            row += '</tr>';
        }

        else{
            if(jj == 0){
                row += '<tr><td colspan=\"9\" style=\"text-align:left\">Non-Racikan</td></tr>'
            }
            jj++;
            row += '<tr>';
            row += '<td>'+eval(jj)+'</td>';
            row += '<td>'+ret.kode_barang+'</td>';
            row += '<td>'+ret.nama_barang+'</td>';
             row += '<td style=\"text-align:right\">'+ret.signa1+'</td>';
            row += '<td style=\"text-align:right\">'+ret.signa2+'</td>';
            row += '<td style=\"text-align:right\">'+ret.harga+'</td>';
            row += '<td style=\"text-align:right\">'+ret.qty+'</td>';
            row += '<td style=\"text-align:right\">'+ret.subtotal_bulat+'</td>';
            row += '<td><a href=\"javascript:void(0)\" class=\"cart-update\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-pencil\"></i></a>';
            row += '&nbsp;<a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-trash\"></i></a></td>';
            row += '</tr>';
        }
        
    });

    row += '<tr>';
    row += '<td colspan=\"7\" style=\"text-align:right\"><strong>Total Biaya</strong></td>';
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


$(document).on('keydown','.calc_kekuatan_modal', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        
        var signa1 = isNaN($('#signa1_update_form').val()) ? 0 : $('#signa1_update_form').val();
        var signa2 = isNaN($('#signa2_update_form').val()) ? 0 : $('#signa2_update_form').val();
        var jumlah_hari = isNaN($('#jumlah_hari_update_form').val()) ? 0 : $('#jumlah_hari_update_form').val();
        if($('#stok_update_form').val() == '' || $('#stok_update_form').val() == '0')
            $('#stok_update_form').val(signa1 * signa2 * jumlah_hari);
        var kekuatan = isNaN($('#kekuatan_update_form').val()) ? 0 : $('#kekuatan_update_form').val();
        var dosis_minta = isNaN($('#dosis_minta_update_form').val()) ? 0 : $('#dosis_minta_update_form').val();
        var jml_racikan = isNaN($('#stok_update_form').val()) ? 0 : $('#stok_update_form').val();

        var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);
        hasil = isNaN(hasil) ? 0 : hasil;
        $('#qty_update_form').val(hasil);
        $('#jumlah_ke_stok_update_form').val(Math.ceil(hasil));
        $('#jumlah_ke_apotik_update_form').val(Math.ceil(hasil));


    }

    
});

$(document).on('keydown','.calc_kekuatan', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();

        var signa1 = isNaN($('#signa1').val()) ? 0 : $('#signa1').val();
        var signa2 = isNaN($('#signa2').val()) ? 0 : $('#signa2').val();
        var jumlah_hari = isNaN($('#jumlah_hari').val()) ? 0 : $('#jumlah_hari').val();
        if($('#stok').val() == '' || $('#stok').val() == '0')
            $('#stok').val(signa1 * signa2 * jumlah_hari);

        var kekuatan = isNaN($('#kekuatan').val()) ? 0 : $('#kekuatan').val();
        var dosis_minta = isNaN($('#dosis_minta').val()) ? 0 : $('#dosis_minta').val();
        var jml_racikan = isNaN($('#stok').val()) ? 0 : $('#stok').val();

        var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);
        hasil = isNaN(hasil) ? 0 : hasil;
        $('#qty').val(hasil);
        $('#jumlah_ke_stok').val(Math.ceil(hasil));
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


$(document).on('keydown','.calc_qtynon_update', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        

        var signa1 = $('#signa1_nonracik_update').val();
        var signa2 = $('#signa2_nonracik_update').val();
        var jmlhari = $('#jumlah_hari_nonracik_update').val();

        signa1 = isNaN(signa1) ? 0 : signa1;
        signa2 = isNaN(signa2) ? 0 : signa2;
        jmlhari = isNaN(jmlhari) ? 0 : jmlhari;
        var qty = eval(signa1) * eval(signa2) * eval(jmlhari);

        $('#qty_nonracik_update').val(qty);
        $('#jumlah_ke_apotik_nonracik_update').val(qty);

    }

    
});

$(document).on('keydown','#customer_id',function(e){
   
    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    if(key == 13){
         e.preventDefault();

        $.ajax({
            url : '/api/ajax-pasien-daftar',
            type : 'GET',
            data : 'term='+$(this).val()+'&jenis_rawat='+$('#jenis_rawat').val(),
            beforeSend : function(){
                $('#loading').show();
            },
            error : function(){
                $('#loading').hide();
            },
            success : function(hasil){
                var data = $.parseJSON(hasil)[0];
                $('#loading').hide();
                 if(data.id != 0){

                    $('#pasien_id').val(data.id);
                    $('#pasien_nama').val(data.namapx);
                    loadItemHistory(data.id);
                    $('#jenis_pasien').val(data.namagol);
                    $('#jenis_resep_nama').val(data.namagol);
                    $('#jenis_resep_id').val(data.jenispx);
                    $('#unit_pasien').val(data.namaunit);
                    $('#unit_id').val(data.kodeunit);
                    $('#kode_daftar').val(data.nodaftar);
                    $('#id_rawat_inap').val(data.id_rawat_inap);
                    $('#tgldaftar').datetextentry('set_date',data.tgldaftar); 
                    $('#dokter_id').val(data.id_dokter);
                    $('#dokter_nama').val(data.nama_dokter);
                }
            }
        });
    }
});

$(document).on('click','a.cart-update', function(e) {

    var id = $(this).attr('data-item');
   
    $.ajax({
        type : 'POST',
        url : '/cart/ajax-get-item',
        data : {dataItem:id},
        beforeSend: function(){

        },
        success : function(data){
            var hsl = jQuery.parseJSON(data);

            if(hsl.code == '200'){
                if(hsl.is_racikan == 1){
                    $('#modal-update-racik-cart').trigger('click');
                    $('#cart_id').val(hsl.id);
                    
                    $('#kode_racikan_update_form').val(hsl.kode_racikan);
                    $('#dept_stok_id_update_form').val(hsl.departemen_stok_id);
                    $('#nama_barang_item_update_form').val(hsl.nama_barang);
                    $('#signa1_update_form').val(hsl.signa1);
                    $('#signa2_update_form').val(hsl.signa2);
                    $('#qty_update_form').val(hsl.qty);
                    $('#kekuatan_update_form').val(hsl.kekuatan);
                    $('#dosis_minta_update_form').val(hsl.dosis_minta);
                    $('#barang_id_update_form').val(hsl.barang_id);
                    $('#harga_jual_update_form').val(hsl.harga_jual);
                    $('#harga_beli_update_form').val(hsl.harga_beli);
                    $('#jumlah_ke_apotik_update_form').val(hsl.jumlah_ke_apotik);
                    $('#jumlah_ke_stok_update_form').val(Math.ceil(hsl.qty));
                    $('#jumlah_hari_update_form').val(hsl.jumlah_hari);
                    $('#departemen_stok_id_update').val(hsl.departemen_stok_id);
                    var kekuatan = hsl.kekuatan;
                    var dosis_minta = hsl.dosis_minta;
                    var qty = hsl.qty;
                    var jumlah_minta = qty * kekuatan / dosis_minta;
                    $('#stok_update_form').val(Math.round(jumlah_minta));
                }

                else{
                    $('#modal-update-cart').trigger('click');
                    $('#cart_id').val(hsl.id);
                    $('#nama_barang_update').val(hsl.nama_barang);
                    $('#signa1_nonracik_update').val(hsl.signa1);
                    $('#signa2_nonracik_update').val(hsl.signa2);
                    $('#qty_nonracik_update').val(hsl.qty);
                    $('#departemen_stok_id_update').val(hsl.departemen_stok_id);
                    $('#harga_jual_nonracik_update').val(hsl.harga_jual);
                    $('#harga_beli_nonracik_update').val(hsl.harga_beli);
                    $('#jumlah_ke_apotik_nonracik_update').val(hsl.jumlah_ke_apotik);
                    $('#jumlah_hari_nonracik_update').val(hsl.jumlah_hari);
                }
            }

            else{
                alert(hsl.message);
            } 
        }
    });
    
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

    $('.duplicate_next').keydown(function(e){
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if(key == 13){
            e.preventDefault();
            var qty = $(this).val();
            qty = isNaN(qty) ? 0 : qty;
            $(this).next().val(Math.ceil(qty));
    
        }
    });


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

    $('#btn-input-update').click(function(e){
        e.preventDefault();
        var departemen_stok_id = $('#departemen_stok_id_update').val();
        var qty = $('#qty_nonracik_update').val();

        if(departemen_stok_id == ''){
            alert('Data Obat tidak boleh kosong');
            return;
        }

        if(qty == ''){
            alert('Jumlah / Qty tidak boleh kosong');
            return;
        }

        obj = new Object;
        obj.cart_id = $('#cart_id').val();
        obj.departemen_stok_id = departemen_stok_id;
        obj.qty = qty;
        obj.kode_transaksi = $('#kode_transaksi').val();
        obj.harga = $('#harga_jual_nonracik_update').val();
        obj.harga_beli = $('#harga_beli_nonracik_update').val();
        obj.subtotal = eval(obj.harga) * eval(obj.qty);
        obj.jumlah_ke_apotik = $('#jumlah_ke_apotik_nonracik_update').val();
        obj.signa1 = $('#signa1_nonracik_update').val();
        obj.signa2 = $('#signa2_nonracik_update').val();
        obj.jumlah_hari = $('#jumlah_hari_nonracik_update').val();

        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/cart/ajax-simpan-item-update',

            success : function(data){
                
                
                var hsl = jQuery.parseJSON(data);
                refreshTable(hsl);
            }
        });
    });

    $('#btn-simpan-item-update').on('click',function(){

        var kekuatan = $('#kekuatan_update_form').val();
        var dosis_minta = $('#dosis_minta_update_form').val();
        var jml_racikan = $('#stok_update_form').val();
        var hasil = Math.ceil(eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan));
        var harga_jual = $('#harga_jual_update_form').val();
        var harga_beli = $('#harga_beli_update_form').val();
       

        item = new Object;
        item.cart_id = $('#cart_id').val();
        item.barang_id = $('#barang_id_update_form').val();
        item.kekuatan = kekuatan;
        item.departemen_stok_id = $('#dept_stok_id_update_form').val();
        item.dosis_minta = dosis_minta;
        item.kode_transaksi = $('#kode_transaksi').val();
        item.kode_racikan = $('#kode_racikan_update_form').val();
        item.is_racikan = 1;
        item.qty = $('#qty_update_form').val();
        item.qty_bulat = Math.ceil(item.qty);
        item.subtotal_bulat = item.qty_bulat * Math.round(harga_jual);
        item.subtotal = item.qty * harga_jual;
        item.signa1 = $('#signa1_update_form').val();
        item.signa2 = $('#signa2_update_form').val();
        item.jumlah_ke_apotik = $('#jumlah_ke_apotik_update_form').val();
        item.harga = harga_jual;
        item.harga_beli = harga_beli;
        
        // $('#qty_update_form').val(hasil);
        $.ajax({
            type : 'POST',
            url : '/cart/ajax-simpan-item-update',
            data : {dataItem:item},
            beforeSend: function(){

                // $('#alert-message').hide();
            },
            success : function(data){

                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){

                    refreshTable(hsl);
                    $('#nama_barang_item').val('');
                    $('#nama_barang_item').focus();
                    $('#kekuatan').val(0);
                    $('#dosis_minta').val(0);
                    $('#qty').val(0);
                    $('#jumlah_ke_apotik').val(0);
                   
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

    $('#btn-bayar').click(function(){
        
        var kode_transaksi = $('#kode_transaksi').val();

        var pasien_id = $('#pasien_id').val();
        var dokter_id = $('#dokter_id').val();
        var jenis_rawat = $('#jenis_rawat').val();

        var obj = new Object;
        obj.kode_transaksi = kode_transaksi;
        obj.customer_id = pasien_id;
        obj.dokter_id = dokter_id;
        
        obj.tanggal = $('#tanggal').val();
        obj.jenis_resep_id = $('#jenis_resep_id').val();
        obj.jenis_rawat = jenis_rawat;
        obj.kode_daftar = $('#kode_daftar').val();
        obj.dokter_nama = $('#dokter_nama').val();
        obj.unit_nama = $('#unit_pasien').val();
        obj.pasien_nama = $('#pasien_nama').val();
        obj.pasien_jenis = $('#jenis_pasien').val();
        obj.unit_id = $('#unit_id').val();
        obj.id_rawat_inap = $('#id_rawat_inap').val();

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
                    var urlEtiket = '/penjualan/print-batch-etiket?id='+id;
                    popitup(urlResep,'resep',0);
                    popitup(urlPengantar,'pengantar',1);    
                    popitup(urlEtiket,'etiket',0);
                    location.reload(); 
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
        obj.qty_bulat = Math.ceil(qty);
        obj.kode_transaksi = $('#kode_transaksi').val();
        obj.harga_beli = $('#harga_beli_nonracik').val();
        obj.harga = $('#harga_jual_nonracik').val();
        obj.subtotal = eval(obj.harga) * eval(obj.qty);
        obj.subtotal_bulat = Math.round(obj.harga) * Math.ceil(obj.qty);
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