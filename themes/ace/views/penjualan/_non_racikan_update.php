  
<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\helpers\Url;

use yii\web\JsExpression;
?>
<style type="text/css">
  ul.ui-autocomplete {
    z-index: 1100;
}
</style>
<form class="form-horizontal" role="form">
    <div class="row">
        <form class="form-horizontal">
        
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Barang</label>

        <div class="col-sm-9">
           
           
           <input type="hidden" id="harga_jual_nonracik_update"/>
           <input type="hidden" id="harga_beli_nonracik_update"/>

               <?php 
    // $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
   
echo AutoComplete::widget([
    'name' => 'nama_barang_update',
    'id' => 'nama_barang_update',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#departemen_stok_id_update').val(ui.item.dept_stok_id);
        $('#harga_jual_nonracik_update').val(ui.item.harga_jual);
        $('#harga_beli_nonracik_update').val(ui.item.harga_beli);
     }")],
    'options' => [
        'size' => '40'
    ]
 ]);
    ?> <br><small>[F8] untuk ke sini</small>
        </div>
    </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Signa 1 </label>

        <div class="col-sm-9">
            <input type="number" id="signa1_nonracik_update" class="calc_qtynon_update" placeholder="Signa 1" size="3" value="0" style="width: 80px" /> x 
            Signa 2
             <input type="number" id="signa2_nonracik_update" class="calc_qtynon_update" placeholder="Signa 2"  size="3" value="0" style="width: 80px"/>
              Hari
             <input type="number" id="jumlah_hari_nonracik_update" class="calc_qtynon_update" placeholder="Jml Hari" value="0" size="3" style="width: 80px" />
             <br>
            
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Qty </label>

        <div class="col-sm-9">
            <input type="number" id="qty_nonracik_update" class="duplicate_next" size="5" value="0"/>
            Jml ke Apotek
            <input type="number" id="jumlah_ke_apotik_nonracik_update" placeholder="Jml ke apotek" size="5" value="0"/>
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> </label>

        <div class="col-sm-9">
           <button id="btn-input-update" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>&nbsp;Update</button>
        </div>
    </div>

        </form>
       
    </div>
</form>