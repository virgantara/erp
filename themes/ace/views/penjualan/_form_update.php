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
    <div class="col-sm-4">
        <form class="form-horizontal">
     <div class="form-group  col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pasien</label>

        <div class="col-sm-10">
            
             <input name="customer_id"  class="form-control"  type="text" id="customer_id" value="<?=$model->penjualanResep->pasien_nama.' '.$model->penjualanResep->pasien_id?>" /> 
             <input name="pasien_nama"  type="hidden" id="pasien_nama" value="<?=$model->penjualanResep->pasien_nama;?>" /> 
              <input name="dokter_id"  type="hidden" id="dokter_id" value="<?=$model->penjualanResep->dokter_id;?>"/>
              <input name="id_rawat_inap"  type="hidden" id="id_rawat_inap" />
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
                 $('#id_rawat_inap').val(ui.item.id_rawat_inap);
                $('#jenis_pasien_nama').val(ui.item.namagol);
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


            <input name="pasien_id"  type="hidden" id="pasien_id" value="<?=$model->penjualanResep->pasien_id;?>"/>
             <input name="kode_daftar"  type="hidden" id="kode_daftar" value="<?=$model->penjualanResep->kode_daftar;?>"/>
  
        </div>
    </div>

     <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tgl Resep</label>
        <div class="col-sm-10">
          <input name="tanggal"  type="text" id="tanggal" value="<?=$model->tanggal;?>"/>
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
 ?>         <input type="text"  class="form-control"  id="unit_pasien" value="<?=$model->penjualanResep->unit_nama;?>"/>
            <input type="hidden" id="unit_id" value="<?=$model->penjualanResep->unit_id;?>"/>
        </div>
    </div>
     <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Dokter</label>
        <div class="col-sm-10">
          <input name="dokter_nama"  class="form-control"  type="text" id="dokter_nama" value="<?=$model->penjualanResep->dokter_nama;?>"/>

            <input name="pasien_id"  type="hidden" id="pasien_id" value="<?=$model->penjualanResep->pasien_id;?>"/>
             <input name="kode_daftar"  type="hidden" id="kode_daftar" value="<?=$model->penjualanResep->kode_daftar;?>"/>
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
     <div class="form-group  col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Px</label>

        <div class="col-sm-10">

            <input type="text"  class="form-control" id="jenis_pasien_nama" value="<?=$model->penjualanResep->pasien_jenis;?>"/>
            <input type="hidden" id="jenis_pasien" value="<?=$model->penjualanResep->pasien_jenis;?>"/>
           
        </div>
    </div>
        <input type="hidden" class="form-control" id="jenis_rawat" value="<?=$model->penjualanResep->jenis_rawat;?>"/>
            

            <input size="12" type="hidden" value="<?=$model->kode_transaksi;?>" id="kode_transaksi" />
            <input  type="hidden" value="<?=$model->id;?>" id="penjualan_id" />
        
      <div class="form-group col-xs-12 col-lg-12">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Jns Resep</label>
        <div class="col-sm-10">
             <input type="text" class="form-control" id="jenis_resep_nama" value="<?=$listJenisResep[$model->penjualanResep->jenis_resep_id];?>"/>
              <input type="hidden" id="jenis_resep_id" value="<?=$model->penjualanResep->jenis_resep_id;?>"/>
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
                <li ">
                    <a data-toggle="tab" href="#home4" id="click-racikan">Racikan [F3]</a>
                </li>
                 <li ">
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
<input type="hidden" id="cart_id"/>
<input type="hidden" id="departemen_stok_id_update"/>
    <div class="col-sm-12">
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
            <?php

            $ii = 0;
            $jj = 0; 
            $no_racik = 0;
            $no_nonracik = 0;
            $total = 0;
            foreach($cart as $q => $item)
            {   
                $total += $item->subtotal;
                if($item->is_racikan)
                {
                    $no_racik++;
                    if($ii == 0){
                echo '<tr><td colspan="9" style="text-align:left">Racikan</td></tr>';
                
                    }
                    $ii++;

                    ?>
                     <tr>
                <td><?=($no_racik);?></td>
                <td><?=$item->departemenStok->barang->kode_barang;?></td>
                <td><?=$item->departemenStok->barang->nama_barang;?></td>
                <td><?=$item->signa1;?></td>
                <td><?=$item->signa2;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($item->harga);?></td>
                <td style="text-align: center;"><?=$item->qty;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($item->subtotal);?></td>
                <td>
            <a href="javascript:void(0)" class="cart-update" data-item="<?=$item->id;?>"><i class="glyphicon glyphicon-pencil"></i></a>
            
            <a href="javascript:void(0)" class="cart-delete" data-item="<?=$item->id;?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
                    <?php
                }

                else{
                    if($jj == 0){
                    
                    echo '<tr><td colspan="9" style="text-align:left">Non-Racikan</td></tr>';
                    
                    }

                    $no_nonracik++;

                    $jj++;
                    ?>
                     <tr>
                <td><?=($no_nonracik);?></td>
                <td><?=$item->departemenStok->barang->kode_barang;?></td>
                <td><?=$item->departemenStok->barang->nama_barang;?></td>
                <td><?=$item->signa1;?></td>
                <td><?=$item->signa2;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($item->harga);?></td>
                <td style="text-align: center;"><?=$item->qty;?></td>
                <td style="text-align: right"><?=\app\helpers\MyHelper::formatRupiah($item->subtotal);?></td>
                <td>
            <a href="javascript:void(0)" class="cart-update" data-item="<?=$item->id;?>"><i class="glyphicon glyphicon-pencil"></i></a>
            <a href="javascript:void(0)" class="cart-delete" data-item="<?=$item->id;?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
                    <?php
                }
            ?>

           
            <?php 
            }

            ?>

            <tr>
                <td colspan="7" style="text-align:right"><strong>Total Biaya</strong></td>
                <td style="text-align:right"><strong><?=\app\helpers\MyHelper::formatRupiah($total);?></strong></td>
                <td></td>
                
            </tr>


        </tbody>
    </table>
    <div style="display: none" id="div-btn-simpan">
        <button class="btn btn-info" id="btn-bayar"><i class="fa fa-print">&nbsp;</i>Simpan & Cetak Semua [F10]</button>
        <button class="btn btn-success" id="btn-bayar-only"><i class="fa fa-print">&nbsp;</i>Simpan [F11]</button>
        <button class="btn btn-info" id="btn-etiket"><i class="fa fa-print">&nbsp;</i>Simpan & Cetak Etiket [F12]</button>
    </div>
     
    </div><!-- /.col -->


<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Cart</h2>',
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
    'header' => '<h2>Update Cart</h2>',
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


function loadItemHistory(customer_id){
   

    if(customer_id == ''){
        alert('Kode Pasien tidak boleh kosong');
        return;
    }

    obj = new Object;
    obj.customer_id = customer_id;
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

function refreshTableHistory(hsl){
    var row = '';
    console.log(hsl.items);
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

    if(hsl.items.length > 0){
        $('#div-btn-simpan').show();
    }

    else{
        $('#div-btn-simpan').hide();   
    }

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
            row += '<td>';
            row += '<a href=\"javascript:void(0)\" class=\"cart-update\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-pencil\"></i></a>';
            row += '&nbsp;<a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-trash\"></i></a>';
            row += '</td>';
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
            row += '<td>';
            row += '<a href=\"javascript:void(0)\" class=\"cart-update\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-pencil\"></i></a>';
            row += '&nbsp;<a href=\"javascript:void(0)\" class=\"cart-delete\" data-item=\"'+ret.id+'\"><i class=\"glyphicon glyphicon-trash\"></i></a>';
            row += '</td>';
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


$(document).on('keydown','.calc_kekuatan_modal', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        

        var kekuatan = $('#kekuatan_update_form').val();
        var dosis_minta = $('#dosis_minta_update_form').val();
        var jml_racikan = $('#stok_update_form').val();

        kekuatan = isNaN(kekuatan) ? 0 : kekuatan;
        dosis_minta = isNaN(dosis_minta) ? 0 : dosis_minta;
        jml_racikan = isNaN(jml_racikan) ? 0 : jml_racikan;

        var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);
        
        $('#qty_update_form').val(hasil);
        $('#jumlah_ke_apotik_update_form').val(Math.ceil(hasil));
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


$(document).on('click','a.cart-print', function(e) {

    var id = $(this).attr('data-item');
   
    var urlResep = '/penjualan/print-etiket?id='+id;
    popitup(urlResep,'Etiket',0);
    
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
                    $('#jumlah_hari_update_form').val(hsl.jumlah_hari);
                    var kekuatan = hsl.kekuatan;
                    var dosis_minta = hsl.dosis_minta;
                    var qty = hsl.qty;
                    var jumlah_minta = qty * kekuatan / dosis_minta;
                    $('#stok_update_form').val(jumlah_minta);
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

    loadItemHistory(".$model->customer_id.");

    if(".count($cart)." > 0){
        $('#div-btn-simpan').show();
    }

    else{
        $('#div-btn-simpan').hide();   
    }

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
            case 122: // F11
                e.preventDefault();
                $('#btn-bayar-only').trigger('click');
            case 123: // F12
                e.preventDefault();
                $('#btn-etiket').trigger('click');
            break;
        }
        
    });


    $('#tanggal').datetextentry(); 
    $('#tgldaftar').datetextentry(); 

    $('#btn-bayar, #btn-bayar-only, #btn-etiket').click(function(){
        var selector_id = $(this).attr('id');
        var kode_transaksi = $('#kode_transaksi').val();
        var pid = $('#penjualan_id').val();
        var pasien_id = $('#pasien_id').val();
        var dokter_id = $('#dokter_id').val();
        var jenis_rawat = $('#jenis_rawat').val();

        var obj = new Object;
        obj.pid = pid;
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

        $.ajax({
            type : 'POST',
            data : {dataItem:obj},
            url : '/cart/ajax-bayar-update',

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
                    
                    if(selector_id == 'btn-bayar'){
                        var urlResep = '/penjualan/print-resep?id='+id;
                        var urlPengantar = '/penjualan/print-pengantar?id='+id;
                        var urlEtiket = '/penjualan/print-batch-etiket?id='+id;
                        popitup(urlResep,'resep',0);
                        popitup(urlPengantar,'pengantar',1);
                        popitup(urlEtiket,'etiket',0);
                    }    

                    else if(selector_id == 'btn-etiket'){
                        var urlEtiket = '/penjualan/print-batch-etiket?id='+id;
                        popitup(urlEtiket,'etiket',0);
                    }
                }

                else{
                    alert(data.message);
                }
                
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
        item.qty = hasil;
        item.subtotal = hasil * harga_jual;
        item.signa1 = $('#signa1_update_form').val();
        item.signa2 = $('#signa2_update_form').val();
        item.jumlah_ke_apotik = $('#jumlah_ke_apotik_update_form').val();
        item.harga = harga_jual;
        item.harga_beli = harga_beli;
        
        $('#qty_update_form').val(hasil);
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
        obj.harga_beli = $('#harga_beli_nonracik').val();
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
