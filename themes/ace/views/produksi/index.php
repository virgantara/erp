<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\helpers\Url;
use yii\web\JsExpression;
$this->title = 'Data Barang Produksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="produksi-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
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
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kode Paket </label>

        <div class="col-sm-9">
            <input type="text" id="kode_barang" readonly="readonly" value="<?=strtoupper(\app\helpers\MyHelper::getRandomString(8,8,false,false,true));?>" placeholder="Kode Paket" class="col-xs-10 col-sm-5" />
            &nbsp;
            <button id="generate_kode"  class="btn btn-info btn-sm"><i class=" fa fa-plus"></i>&nbsp;Racikan Baru</button>
        </div>

    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Paket </label>

        <div class="col-sm-9">
            <input type="text" id="nama_barang" placeholder="Nama Paket" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Satuan</label>

        <div class="col-sm-9">
            <input type="text" id="id_satuan" placeholder="Satuan" class="col-xs-10 col-sm-5" />
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
     }")],
    'options' => [
        'size' => '40'
    ]
 ]); 
 ?>
            <input type="text" id="nama_barang_item" placeholder="Kode Barang" class="col-xs-10 col-sm-5" />
             <input type="hidden" id="barang_id"/>
               <input type="hidden" id="kode_barang_item"/>
               <input type="hidden" id="nama_barang_items"/>
                 <!-- <input type="hidden" id="nama_barang"/> -->
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Kekuatan </label>

        <div class="col-sm-9">
            <input type="text" id="kekuatan" placeholder="Kekuatan" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Dosis Minta </label>

        <div class="col-sm-9">
            <input type="text" id="dosis_minta" placeholder="Dosis Minta" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-simpan-item">
                <i class="ace-icon fa fa-plus bigger-110"></i>
                Tambah
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
            <th>Kekuatan</th>
            <th>Dosis Minta</th>
            <th>Qty</th>
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
   <div class="col-xs-7">
    <div class="widget-box">
        <div class="widget-header widget-header-flat">
            <h4 class="widget-title">List Paket</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main">
                <div class="row">
                    <?php 
\yii\widgets\Pjax::begin(['id' => 'pjax-container']);
 ?> 
        <?php 

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'namaBarang',
          
            'barang.id_satuan',
            'stok',           
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'onclick' => "
                                    if (confirm('Are you sure you want to delete this item?')) {
                                        $.ajax('$url', {
                                            type: 'POST'
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#pjax-container'});
                                            $('#alert-message').html('<div class=\"alert alert-success\">Data berhasil dihapus</div>');
                                            $('#alert-message').show();    
                                            $('#alert-message').fadeOut(2500);
                                        });
                                    }
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                    'update' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                    'onclick' => "
                                    
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },

                    'view' => function ($url, $model) {
                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                   'title'        => 'view',
                                   'data-item' => $model->barang_id,
                                   'class' => 'view-barang'
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                ],
                
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                   

                    if ($action === 'delete') {
                        $url =Url::to(['departemen-stok/ajax-delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['sales-master-barang/update','id'=>$model->barang_id]);
                        return $url;
                    }


                  }
            ],
        ],
    ]); 
    ?>
     <?php \yii\widgets\Pjax::end(); ?>
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
     <input type="hidden" id="stok_update"/>
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
    var id = $('#barang_id_update').val();
    var kekuatan = $('#kekuatan_update').val();

    var dosis_minta = $('#dosis_minta_update').val();
    var jml_racikan = $('#stok').val();
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
            console.log(hsl);
            if(hsl.code == '200'){
                refreshTable(hsl.items);
               
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
    $('#barang_id_update').val($(this).attr('data-item'));
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
                    refreshTable(hsl.items);
                    
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

    $.ajax({
        type : 'POST',
        url : '/produksi/ajax-load-item',
        data : {dataItem:id},
        beforeSend: function(){

        },
        success : function(data){
            var hsl = jQuery.parseJSON(data);

            if(hsl.code == '200'){
                refreshTable(hsl.items);
                
            }

            else{
                alert(hsl.message);
            } 
        }
    });
});

function refreshTable(values){
    $('#tabel-komposisi > tbody').empty();
    var row = '';
    var parent_id = '';
    var stok = 0;
    $.each(values,function(i,obj){
        row += '<tr>';
        row += '<td>'+eval(i+1)+'</td>';
        row += '<td>'+obj.kode_barang+'</td>';
        row += '<td>'+obj.nama_barang+'</td>';
        row += '<td>'+obj.kekuatan+'</td>';
        row += '<td>'+obj.dosis_minta+'</td>';
        row += '<td>'+obj.jumlah+'</td>';
        row += '<td>';
        row += '<a href=\"javascript:void(0)\" data-item=\"'+obj.id+'\" data-dosis=\"'+obj.dosis_minta+'\" data-kekuatan=\"'+obj.kekuatan+'\" class=\"update-item btn btn-info btn-xs\"><i class=\"fa fa-pencil\"></i></a>&nbsp;';
        row += '<a href=\"javascript:void(0)\" data-item=\"'+obj.id+'\" class=\"delete-item btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i></a>';
        row += '</td>';
        row += '</tr>';
        parent_id = obj.parent_id;
        // stok = obj.
    });

    $('#kode_barang').val(parent_id);
    $('#stok').val();
    $('#tabel-komposisi > tbody').append(row);
}


jQuery(function($){


    $('#generate_kode').click(function(e){
        e.preventDefault();
        $.ajax({
          type : 'post',
          url : '/produksi/ajax-generate-code',
          success : function(res){
            
            var res = $.parseJSON(res);
            
            $('#kode_barang').val(res);

            
          },
        });
    });


    $('#btn-simpan-item').on('click',function(){

        var kekuatan = $('#kekuatan').val();
        var dosis_minta = $('#dosis_minta').val();
        var jml_racikan = $('#stok').val();
        var hasil = eval(jml_racikan) * eval(dosis_minta) / eval(kekuatan);

        paket = new Object;
        paket.nama_barang = $('#nama_barang').val();
        paket.kode_barang = $('#kode_barang').val();
        paket.stok = jml_racikan;
        paket.id_satuan = $('#id_satuan').val();

        item = new Object;
        item.kode_barang = $('#kode_barang_item').val();
        item.nama_barang = $('#nama_barang_items').val();
        item.barang_id = $('#barang_id').val();
        item.kekuatan = kekuatan;
        item.dosis_minta = dosis_minta;
        
        item.jumlah = hasil;

        
        
        $.ajax({
            type : 'POST',
            url : '/produksi/ajax-simpan-item',
            data : {dataItem:item,dataPaket:paket},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    refreshTable(hsl.items);
                    // $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('Data telah disimpan');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2000);
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