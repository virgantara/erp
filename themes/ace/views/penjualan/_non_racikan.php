  
<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\helpers\Url;

use yii\web\JsExpression;
?>
   <div class="row">
        <form class="form-horizontal">
      
        <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Barang</label>

        <div class="col-sm-9">
           <input type="hidden" id="departemen_stok_id"/>
           <input type="hidden" id="harga_jual_nonracik"/>

               <?php 
    // $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
   
echo AutoComplete::widget([
    'name' => 'nama_barang',
    'id' => 'nama_barang',
    'clientOptions' => [
    'source' => Url::to(['departemen-stok/ajax-barang']),
    'autoFill'=>true,
    'minLength'=>'1',
    'select' => new JsExpression("function( event, ui ) {
        $('#departemen_stok_id').val(ui.item.dept_stok_id);
        $('#harga_jual_nonracik').val(ui.item.harga_jual);
     }")],
    'options' => [
        'size' => '40',
        'tabindex' => 6
    ]
 ]);
    ?> <br><small>[F8] untuk ke sini</small>
        </div>
    </div>
      <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Signa 1 </label>

        <div class="col-sm-9">
            <input type="number" id="signa1_nonracik" class="calc_qtynon" placeholder="Signa 1" size="3" value="0" style="width: 80px" /> x 
            Signa 2
             <input type="number" id="signa2_nonracik" class="calc_qtynon" placeholder="Signa 2"  size="3" value="0" style="width: 80px"/>
              Hari
             <input type="number" id="jumlah_hari_nonracik" class="calc_qtynon" placeholder="Jml Hari" value="0" size="3" style="width: 80px" />
             <br>
            
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Qty </label>

        <div class="col-sm-9">
            <input type="number" id="qty_nonracik" size="5" value="0"/>
            Jml ke Apotek
            <input type="number" id="jumlah_ke_apotik_nonracik" placeholder="Jml ke apotek" size="5" value="0"/>
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> </label>

        <div class="col-sm-9">
           <button id="btn-input" class="btn btn-info btn-sm"><i class="fa fa-plus"></i>&nbsp;Tambah</button>
        </div>
    </div>

        </form>
       
    </div>