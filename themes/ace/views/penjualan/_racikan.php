<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\web\JsExpression;
// $this->title = 'Data Barang Produksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produksi-index">

<div class="row">
   <div class="col-lg-5">
    <div class="widget-box">
        
        <div class="widget-header widget-header-flat">
            <h4 class="widget-title">Data Paket</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row">
                   <form class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Racikan </label>

        <div class="col-sm-9">
            <input type="text" id="kode_racikan" readonly="readonly" value="<?=strtoupper(\app\helpers\MyHelper::getRandomString(8,8,false,false,true));?>" placeholder="Kode Racikan" class="col-xs-10 col-sm-5" />
            &nbsp;
            <button id="generate_kode"  class="btn btn-info btn-sm"><i class=" fa fa-plus"></i>&nbsp;Racikan Baru [F9]</button>
        </div>

    </div>
    
   
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Signa 1 </label>

        <div class="col-sm-9">
            <input type="number" id="signa1" class="calc_kekuatan" placeholder="Signa 1" size="3" style="width: 80px"/> x 
            Signa 2
             <input type="number" id="signa2" class="calc_kekuatan" placeholder="Signa 2"  size="3"  style="width: 80px"/>
              Hari
             <input type="number" id="jumlah_hari" class="calc_kekuatan" placeholder="Jml Hari"  size="3" style="width: 80px" />
            <br>
            <small>[F8] untuk ke sini</small>
        </div>

    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah yang diminta </label>

        <div class="col-sm-9">
            <input type="text" id="stok" placeholder="Jumlah yang diminta" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    
    <hr/>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Barang </label>

        <div class="col-sm-9">
               <?php 
            AutoComplete::widget([
    'name' => 'nama_barang_item',
    'id' => 'nama_barang_item',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#barang_id').val(ui.item.id);
        $('#kode_barang_item').val(ui.item.kode);
         $('#nama_barang_items').val(ui.item.nama);
        $('#dept_stok_id').val(ui.item.dept_stok_id);
        $('#harga_jual').val(ui.item.harga_jual);
        $('#harga_beli').val(ui.item.harga_beli);
        $('#kekuatan').val(ui.item.kekuatan);
     }")],
    'options' => [
        'size' => '40'
    ]
 ]); 
 ?>
            <input type="text" id="nama_barang_item" placeholder="Kode Barang" class="col-xs-10 col-sm-5" />
             <input type="hidden" id="barang_id"/>
             <input type="hidden" id="dept_stok_id"/>
              <input type="hidden" id="harga_jual"/>
              <input type="hidden" id="harga_beli"/>
                 <!-- <input type="hidden" id="nama_barang"/> -->
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kekuatan </label>

        <div class="col-sm-9">
            <input type="text" id="kekuatan" placeholder="Kekuatan" class="calc_kekuatan" style="width: 80px"/>
            Dosis Minta
            <input type="text" id="dosis_minta" placeholder="Dosis Minta" class="calc_kekuatan" style="width: 80px"/>
        </div>
    </div>


     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Qty </label>

        <div class="col-sm-9">
            <input type="text" id="qty" size="5" class="calc_kekuatan" style="width: 80px"/>
            
        </div>
    </div>
    
    
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jml ke stok </label>

        <div class="col-sm-9">
            <input type="text" id="jumlah_ke_stok" size="5" class="duplicate_next" style="width: 80px"/>
            Jml ke Apotek
            <input type="text" id="jumlah_ke_apotik" size="5" style="width: 80px"/>
        </div>
    </div>
    
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
          
            <button class="btn btn-success" type="button" id="btn-simpan-item">
                <i class="ace-icon fa fa-plus bigger-110"></i>
                Input Obat [F2]
            </button>

           
        </div>
    </div>
   
</form>
                </div>

              
            </div>
        </div>
                                        
    </div>

   </div>
   <div class="col-lg-7">
    <div class="widget-box">
        
        <div class="widget-header widget-header-flat">
            <h4 class="widget-title">Item Komposisi</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row">
<div class="alert alert-success" id="alert-message" style="display: none">Data Tersimpan</div>
<table class="table table-striped" id="tabel-komposisi">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Dosis Minta</th>
            <th>Aturan</th>
            <th>Qty</th>
            <th>Subtotal</th>
            
            <th>Opsi</th>
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
  
</div>


<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Data</h2>',
    'toggleButton' => ['label' => '','id'=>'modal-update','style'=>'display:none'],
    
]);

?>
<form class="form-horizontal" role="form">
     <input type="hidden" id="barang_id_update"/>
     <input type="hidden" id="jumlah_update"/>
     <input type="hidden" id="produksi_item_update"/>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kekuatan </label>

        <div class="col-sm-9">
            <input type="text" id="kekuatan_update" placeholder="Kekuatan" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Dosis Minta </label>

        <div class="col-sm-9">
            <input type="text" id="dosis_minta_update" placeholder="Dosis Minta" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-update-item">
                <i class="ace-icon fa fa-pencil bigger-110"></i>
                Update
            </button>

           
        </div>
    </div>
   
</form>
<?php

\yii\bootstrap\Modal::end();
?>
</div>
<?php
$script = "
$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        var inputs = $(this).closest('.produksi-index').find(':input:visible');
              
        inputs.eq( inputs.index(this)+ 1 ).focus().select();
        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 10);

    }
});

$(document).on('click','#btn-update-item', function(e) {
    var id = $('#produksi_item_update').val();
    var kekuatan = $('#kekuatan_update').val();

    var dosis_minta = $('#dosis_minta_update').val();
    var jml_racikan = $('#jumlah_update').val();
    var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);

    item = new Object;
    item.kode_barang = $('#kode_barang_item').val();
    item.nama_barang = $('#nama_barang_items').val();
    item.barang_id = $('#barang_id_update').val();
    item.kekuatan = kekuatan;
    item.dosis_minta = dosis_minta;
    
    item.jumlah = hasil;

    
    
    $.ajax({
        type : 'POST',
        url : '/produksi/ajax-update-item',
        data : {dataItem:item,dataId:id},
        success : function(data){
            var hsl = jQuery.parseJSON(data);
            if(hsl.code == '200'){
                refreshTable(hsl);
                $.pjax.reload({container: '#pjax-container'});
            }

            else{
                alert(hsl.message);
            } 
        }
    });

    
});


$(document).on('click','a.update-item', function(e) {
    $('#modal-update').trigger('click');
    $('#kekuatan_update').val($(this).attr('data-kekuatan'));
    $('#dosis_minta_update').val($(this).attr('data-dosis'));
    $('#barang_id_update').val($(this).attr('data-id'));
    $('#produksi_item_update').val($(this).attr('data-item'));

});

$(document).on('click','a.delete-item', function(e) {
    var conf = confirm('Hapus data ini?');
    if(conf){
        var id = $(this).attr('data-item');
        $.ajax({
            type : 'POST',
            url : '/produksi/ajax-hapus-item',
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

$(document).on('click','a.view-barang', function(e) {

    var id = $(this).attr('data-item');
    $('#jumlah_update').val($(this).attr('data-qty'));
    $.ajax({
        type : 'POST',
        url : '/produksi/ajax-load-item',
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
});

function refreshTableRacikan(values){
    $('#tabel-komposisi > tbody').empty();
    var row = '';

    $.each(values,function(i,obj){

        row += '<tr>';
        row += '<td>'+eval(i+1)+'</td>';
        row += '<td>'+obj.kode_barang+'</td>';
        row += '<td>'+obj.nama_barang+'</td>';
        row += '<td>'+obj.dosis_minta+'</td>';
        row += '<td>'+obj.signa1+' x '+obj.signa2+'</td>';
        row += '<td>'+obj.qty+'</td>';
        row += '<td>'+obj.subtotal+'</td>';

        row += '<td>';
        row += '<a href=\"javascript:void(0)\" data-item=\"'+obj.id+'\" data-id=\"'+obj.barang_id+'\" data-dosis=\"'+obj.dosis_minta+'\" data-kekuatan=\"'+obj.kekuatan+'\" class=\"update-item btn btn-info btn-xs\"><i class=\"fa fa-pencil\"></i></a>&nbsp;';
        row += '<a href=\"javascript:void(0)\" data-item=\"'+obj.id+'\" class=\"delete-item btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i></a>';
        row += '</td>';
        row += '</tr>';
    });

    

    $('#tabel-komposisi > tbody').append(row);
}


$(document).ready(function(){

   
    $('#generate_kode').click(function(e){
        e.preventDefault();
        var conf = confirm('Generate Kode Racikan Baru?');

        if(conf){

            $('#signa1').focus();

            $.ajax({
              type : 'post',
              url : '/produksi/ajax-generate-code',
              success : function(res){
                
                var res = $.parseJSON(res);
                
                $('#kode_racikan').val(res);

                
              },
            });
        }
    });


    $('#btn-simpan-item').on('click',function(){

        var kekuatan = $('#kekuatan').val();
        var dosis_minta = $('#dosis_minta').val();
        var jml_racikan = $('#stok').val();
        var hasil = Math.ceil(eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan));
        var harga_jual = $('#harga_jual').val();
        var harga_beli = $('#harga_beli').val();
       

        item = new Object;
        item.kode_barang = $('#kode_barang_item').val();
        item.nama_barang = $('#nama_barang_items').val();
        item.barang_id = $('#barang_id').val();
        item.kekuatan = kekuatan;
        item.departemen_stok_id = $('#dept_stok_id').val();
        item.dosis_minta = dosis_minta;
        item.kode_transaksi = $('#kode_transaksi').val();
        item.kode_racikan = $('#kode_racikan').val();
        item.jumlah_hari = $('#jumlah_hari').val();
        item.is_racikan = 1;
        item.qty = $('#qty').val();
        item.qty_bulat = Math.ceil(item.qty);
        item.subtotal = item.qty * harga_jual;
        item.subtotal_bulat = item.qty_bulat * harga_jual;
        item.signa1 = $('#signa1').val();
        item.signa2 = $('#signa2').val();
        item.jumlah_ke_apotik = $('#jumlah_ke_apotik').val();
        item.harga = harga_jual;
        item.harga_beli = harga_beli;
        
        // $('#qty').val(hasil);
        $.ajax({
            type : 'POST',
            url : '/cart/ajax-simpan-item',
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
                    // $.ajax({
                    //   type : 'post',
                    //   url : '/produksi/ajax-generate-code',
                    //   success : function(res){
                        
                    //     var res = $.parseJSON(res);
                        
                    //     $('#kode_racikan').val(res);

                        
                    //   },
                    // });
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>