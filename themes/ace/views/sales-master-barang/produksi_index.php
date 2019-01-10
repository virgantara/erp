<?php

use yii\helpers\Html;
use yii\grid\GridView;


$this->title = 'Data Barang Produksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">
   <div class="col-lg-6">
 <form class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Paket </label>

        <div class="col-sm-9">
            <input type="text" id="kode_barang" placeholder="Kode Paket" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Paket </label>

        <div class="col-sm-9">
            <input type="text" id="nama_barang" placeholder="Nama Paket" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Satuan </label>

        <div class="col-sm-9">
            <input type="text" id="id_satuan" placeholder="Satuan" class="col-xs-10 col-sm-5" />
        </div>
    </div>
   
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-simpan">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Simpan
            </button>

           
        </div>
    </div>
</form>
   </div>
   <div class="col-lg-6">
      <form class="form-horizontal" role="form">

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Barang </label>

        <div class="col-sm-9">
            <input type="text" id="kode_barang_komponen" placeholder="Kode Barang" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah </label>

        <div class="col-sm-9">
            <input type="text" id="nama_barang" placeholder="Nama Paket" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Satuan </label>

        <div class="col-sm-9">
            <input type="text" id="id_satuan" placeholder="Satuan" class="col-xs-10 col-sm-5" />
        </div>
    </div>
   
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-simpan">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Simpan
            </button>

           
        </div>
    </div>
</form>
   </div>
</div>
    <div class="alert alert-success" id="alert-message" style="display: none">Data Tersimpan</div>
<?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kode_barang',
            'nama_barang',

            [
             'attribute' =>'harga_beli',
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],

            ],
           [
             'attribute' =>'harga_jual',
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],

            ],
            'totalStok',
            'id_satuan',

            //'created',
            //'id_perusahaan',
            //'id_gudang',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>


<?php
$script = "

jQuery(function($){


    $('#btn-add').on('click',function(){

        $('#modal-form').click();
    });


    $('#btn-simpan').on('click',function(){


        item = new Object;
        item.kode_barang = $('#kode_barang').val();
        item.nama_barang = $('#nama_barang').val();
        item.id_satuan = $('#id_satuan').val();
      
        $.ajax({
            type : 'POST',
            url : '/sales-master-barang/ajax-simpan',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('Data telah disimpan');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

    $('#input-barang').on('click',function(){
        var ro_id = $('#ro_id').val();
        var stok_id = $('#id_stok').val();
        var jml_minta = $('#jml_minta').val();
        var item_id = $('#item_id').val();
        var satuan = $('#satuan').val();
       

        item = new Object;
        item.ro_id = ro_id;
        item.stok_id = stok_id;
        item.jml_minta = jml_minta;
        item.item_id = item_id;
        item.satuan = satuan;
      
        $.ajax({
            type : 'POST',
            url : '/request-order-item/ajax-create',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);
                
                if(hsl.code == '200'){
                    
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('Data telah disimpan');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
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