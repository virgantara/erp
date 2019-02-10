<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\web\JsExpression;
?>
<div class="row">
   <div class="col-lg-12">
    <div class="widget-box">
        
        <div class="widget-header widget-header-flat">
            <h4 class="widget-title">Data Paket</h4>
        </div>

        <div class="widget-body">
            <div class="widget-main">
                <div class="row">
                   <form class="form-horizontal" role="form">
    <div class="col-lg-6">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Racikan </label>

        <div class="col-sm-9">
            <input type="text" id="kode_racikan_update_form" readonly="readonly" placeholder="Kode Racikan" class="col-xs-10 col-sm-5" />
            &nbsp;
            <button id="generate_kode_update"  class="btn btn-info btn-sm"><i class=" fa fa-plus"></i>&nbsp;Racikan Baru [F9]</button>
        </div>

    </div>
    
   
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Signa 1 </label>

        <div class="col-sm-9">
            <input type="number" id="signa1_update_form" placeholder="Signa 1" size="3" style="width: 80px"/> 
                       <small>[F8] untuk ke sini</small>
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Signa 2 </label>

        <div class="col-sm-9">
            <input type="number" id="signa2_update_form" placeholder="Signa 2" size="3" style="width: 80px"/> 
             
        </div>

    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Hari </label>

        <div class="col-sm-9">
           
             <input type="number" id="jumlah_hari_update_form" placeholder="Jml Hari"  size="3" style="width: 80px" />
            <br>
            
        </div>

    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah yang diminta </label>

        <div class="col-sm-9">
            <input type="text" id="stok_update_form" placeholder="Jumlah yang diminta" class="col-xs-10 col-sm-5 calc_kekuatan_modal" />
        </div>
    </div>
    </div>
    <div class="col-lg-6">
    
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Barang </label>

        <div class="col-sm-9">
               <?php 
            AutoComplete::widget([
    'name' => 'nama_barang_item_update_form',
    'id' => 'nama_barang_item_update_form',
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
        $('#kekuatan').val(ui.item.kekuatan);
     }")],
    'options' => [
        'size' => '40'
    ]
 ]); 
 ?>
            <input type="text" id="nama_barang_item_update_form" placeholder="Kode Barang" class="col-xs-10 col-sm-5" />
             <input type="hidden" id="barang_id_update_form"/>
             <input type="hidden" id="dept_stok_id_update_form"/>
              <input type="hidden" id="harga_jual_update_form"/>
                 <!-- <input type="hidden" id="nama_barang"/> -->
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kekuatan </label>

        <div class="col-sm-9">
            <input type="text" id="kekuatan_update_form" placeholder="Kekuatan" class="col-xs-10 col-sm-5 calc_kekuatan_modal" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Dosis Minta </label>

        <div class="col-sm-9">
            <input type="text" id="dosis_minta_update_form" placeholder="Dosis Minta" class="col-xs-10 col-sm-5 calc_kekuatan_modal" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Qty </label>

        <div class="col-sm-9">
            <input type="number" id="qty_update_form" size="5" style="width: 80px"/>
            Jml ke Apotek
            <input type="number" id="jumlah_ke_apotik_update_form" placeholder="Jml ke apotek" size="5" style="width: 80px"/>
        </div>
    </div>
    
    
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
          
            <button class="btn btn-success" type="button" id="btn-simpan-item-update">
                <i class="ace-icon fa fa-plus bigger-110"></i>
                Update Obat [F2]
            </button>

           
        </div>
    </div>
   </div>
</form>
                </div>

              
            </div>
        </div>
                                        
    </div>

   </div>
   <div class="col-lg-12">
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
