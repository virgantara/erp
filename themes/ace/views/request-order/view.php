<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\jui\AutoComplete;
use yii\grid\GridView;
use yii\web\JsExpression;

use app\models\SalesGudang;


$listDataGudang=SalesGudang::getListGudangs();

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = Yii::$app->name.' | Item '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Permintaan Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-view">

      <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

<?php

$url = '';
$userRole = Yii::$app->user->identity->access_role;
$acl = [
    Yii::$app->user->can('gudang'),
    // Yii::$app->user->can('operatorCabang'),
    Yii::$app->user->can('distributor')
];
if(in_array($userRole, $acl)){
    
    // if($model->is_approved !=1){
        $label = 'Setujui Permintaan Obat';
        $kode = 1;
        $warna = 'info';
        echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => $label.' permintaan ini?',
                'method' => 'post',
            ],
        ]);
        echo '&nbsp;';
        echo Html::a('<i class="fa fa-print"></i>Cetak', ['print', 'id' => $model->id], ['class' => 'btn btn-primary']);
    // }
    
} 

if(Yii::$app->user->can('kepalaCabang')){
    $url = 'approveRo';
    $label = '';
    $kode = 0;
    $warna = '';
    if($model->is_approved_by_kepala ==1){
        $label = 'Batal Setujui';
        $kode = 2;
        $warna = 'warning';
    }

    else{
        $label = 'Setujui BON Permintaan';
        $kode = 1;
        $warna = 'info';
    }

    echo '&nbsp;';
    echo Html::a($label, ['approve-ro', 'id' => $model->id,'kode'=>$kode], [
        'class' => 'btn btn-'.$warna,
        'data' => [
            'confirm' => $label.' permintaan ini?',
            'method' => 'post',
        ],
    ]);
} 
?>
    </p>
     <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <i class="icon fa fa-check"></i><?= Yii::$app->session->getFlash('success') ?>
         
    </div>
<?php endif; ?>
<div class="col-xs-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'no_ro',
            'petugas1',
            'petugas2',
            'namaDeptAsal',
            
        ],
    ]) ?>
</div>
<div class="col-xs-6">
     <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'tanggal_pengajuan',
            'tanggal_penyetujuan',
            // 'perusahaan_id',
            'created',
        ],
    ]) ?>

</div>
<p>
<div class="row">
    <div class="col-xs-12">
    <?= Html::a('<i class="fa fa-download"></i>&nbsp;Download Template Item',Url::to(['/request-order/template']),['class' => 'btn btn-info']);?>
    </div>
    
</div>
</p>
<?php 


if($model->departemen_id == Yii::$app->user->identity->departemen || Yii::$app->user->can('gudang')){
?>   

    <div class="row" >
        <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Gudang</th>
            <th>Data</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Jml minta</th>
            <th>Satuan</th>
            <th>Opsi</th>
        </tr>
        <tr><td>
             <?= Html::dropDownList('gudang_id',null,$listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang']); ?>
        </td>
            <td width="30%">
                 <?php 
    $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
    $template = '<div><p class="repo-language">{{nama}}</p>' .
    '<p class="repo-name">{{kode}}</p>';
    echo \kartik\typeahead\Typeahead::widget([
    'name' => 'kd_barang',
    'value' => '',
    'options' => ['placeholder' => 'Ketik nama barang ...'],
    'pluginOptions' => ['highlight'=>true],
    'pluginEvents' => [
        "typeahead:select" => "function(event,ui) { 
            $('#jml_minta').focus();

            $('#kode_barang').val(ui.kode);
            $('#nama_barang').val(ui.nama);
            $('#id_stok').val(ui.id_stok);
            $('#item_id').val(ui.id);
            $('#jml_minta').val('0');
            $('#satuan').val(ui.satuan);
        }",
    ],
    
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            // 'prefetch' => $baseUrl . '/samples/countries.json',
            'remote' => [
                'url' => Url::to(['sales-stok-gudang/ajax-barang']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ],
            'templates' => [
                'notFound' => '<div class="text-danger" style="padding:0 8px">Data Item Barang tidak ditemukan.</div>',
                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
            ]
        ]
    ]
]);
    ?>
              

            </td>
            <td ><input id="kode_barang" type="text" class="form-control"></td>
            <td >
                <input id="ro_id" type="hidden" value="<?=$model->id;?>">
                <input id="id_stok" type="hidden">
                <input id="item_id" type="hidden">
                <input id="nama_barang" type="text" class="form-control">
            </td>
            <td ><input id="jml_minta" type="text" class="form-control"></td>
            <td ><input id="satuan" type="text" class="form-control"></td>
            <td><button class="btn btn-sm btn-primary" id="input-barang"><i class="fa fa-plus"></i> Input</button></td>
        </tr>
    </table>
</div>
    </div>
    <?php 
}
    ?>
      <p>
        <div class="alert alert-success" id="alert-message" style="display: none">Data Tersimpan</div>
        <?php 
    //      if(Yii::$app->user->can('operatorCabang')) {
    //     echo Html::a('Create Request Order Item', ['/request-order-item/create','ro_id'=>$model->id], ['class' => 'btn btn-success']);
    // }
         ?>
    </p>

<?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?>    
     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item.kode_barang',
            'item.nama_barang',
            'jumlah_minta',
            [
                'attribute' => 'jumlah_beri',
                'value' => function($model, $url){
                    if(Yii::$app->user->can('gudang')){
                        return $model->jumlah_beri;    
                    }

                    else if(Yii::$app->user->can('operatorCabang')){
                        return $model->ro->is_approved ? $model->jumlah_beri : 0;   
                    }
                     
                }
                    
            ],
            'satuan',
            'keterangan',
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{updateMinta} {update} {delete}',
                'visibleButtons' => [
                    'view' => function($data){
                        return !Yii::$app->user->can('kepalaCabang');
                    },
                    'update' => function($data){
                        return $data->ro->departemen_id != Yii::$app->user->identity->departemen && !Yii::$app->user->can('kepalaCabang');
                    },
                    'updateMinta' => function($data){
                        return Yii::$app->user->can('kepalaCabang');
                    },
                    'delete' => function($data){
                       return !Yii::$app->user->can('kepalaCabang');
                    },
                ],
                'buttons' => [
                    'update' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                   'class' => 'btn-update',
                                   'data-item' => $model->id,
                                    'onclick' => "
                                    $('#ro-item-id').val(".$model->id.");
                                    $('#jumlah-beri').val(".$model->jumlah_beri.");
                                    $('#ket-beri').val('".$model->keterangan."');

                                    
    
                                    
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                     'updateMinta' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update Permintaan',
                                    'onclick' => "
                                    $('#ro-item-id').val(".$model->id.");
                                    $('#jumlah-minta').val(".$model->jumlah_minta.");
                                    $('#ket-beri').val('".$model->keterangan."');
                                    $('#popup-minta').trigger('click');
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'onclick' => "
                                    if (confirm('Are you sure you want to delete this item?')) {
                                        $.ajax('$url', {
                                            type: 'POST'
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#pjax-container'});
                                            $('#alert-message').html('Data berhasil dihapus');
                                            $('#alert-message').show();    
                                            $('#alert-message').fadeOut(2500);
                                        });
                                    }
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =Url::to(['request-order-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['request-order-item/update','id'=>$model->id,'ro_id'=>$model->ro_id]);
                        return $url;
                    }

                    else if ($action === 'updateMinta') {
                        $url =Url::to(['request-order-item/update','id'=>$model->id,'ro_id'=>$model->ro_id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['request-order-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>

<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Konfirmasi Pemberian</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
]);

?>
<form class="form-horizontal" role="form">
    
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Barang </label>

        <div class="col-sm-9">

            <select name="barang_id" id="barang_id">
                
            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">EXP Date </label>

        <div class="col-sm-9">

            <input type="text" id="exp_date" placeholder="Exp Date" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch No. </label>

        <div class="col-sm-9">

            <input type="text" id="batch_no" placeholder="Batch No" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sisa Stok </label>

        <div class="col-sm-9">

            <input type="text" id="sisa_stok" placeholder="Sisa" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Beri </label>

        <div class="col-sm-9">
            <input type="hidden" id="ro-item-id"/>
            <input type="text" id="jumlah-beri" placeholder="Jumlah Beri" class="col-xs-10 col-sm-5" />
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Keterangan </label>

        <div class="col-sm-9">
            <input type="text" id="ket-beri" placeholder="Keterangan" class="col-xs-10 col-sm-5" />
        </div>
    </div>
   
    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-beri">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Submit
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
            </button>
        </div>
    </div>
</form>
<?php

\yii\bootstrap\Modal::end();
?>
<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Permintaan</h2>',
    'toggleButton' => ['label' => '','id'=>'popup-minta','style'=>'display:none'],
]);

?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Minta </label>

        <div class="col-sm-9">
            <input type="hidden" id="ro-item-id"/>
            <input type="text" id="jumlah-minta" placeholder="Jumlah Minta" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Keterangan </label>

        <div class="col-sm-9">
            <input type="text" id="ket-beri" placeholder="Keterangan" class="col-xs-10 col-sm-5" />
        </div>
    </div>
   
    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-minta">
                <i class="ace-icon fa fa-check bigger-110"></i>
                Submit
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                Reset
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

jQuery(function($){

    $('#barang_id').change(function(){

        var exp_date = $('option:selected',this).attr('data-exp');
        var batch_no = $('option:selected',this).attr('data-batch');
        var jumlah = $('option:selected',this).attr('data-jumlah');
        $('#exp_date').val(exp_date);
        $('#batch_no').val(batch_no);
        $('#sisa_stok').val(jumlah);
    });

     $('#btn-minta').on('click',function(){

        var jml_minta = $('#jumlah-minta').val();
        var keterangan = $('#ket-beri').val();

        item = new Object;
        item.ro_id = $('#ro-item-id').val();
        item.keterangan = keterangan;
        item.jml_minta = jml_minta;
      
        $.ajax({
            type : 'POST',
            url : '/request-order-item/ajax-update-item-minta',
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


    $('#btn-beri').on('click',function(){

        var jml_beri = $('#jumlah-beri').val();
        var keterangan = $('#ket-beri').val();

        item = new Object;
        item.ro_id = $('#ro-item-id').val();
        item.keterangan = keterangan;
        item.jml_beri = jml_beri;
      
        $.ajax({
            type : 'POST',
            url : '/request-order-item/ajax-update-item',
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
        item.gudang_id = $('#id_gudang').val();
      
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

$(document).on('click','.btn-update',function(e){

    var id = $(this).attr('data-item');

    $.ajax({
        type : 'POST',
        url : '/request-order-item/ajax-get-item',
        data : {dataItem:id},
        beforeSend: function(){
            $('#barang_id').empty();
        },
        success : function(data){
            var hsl = jQuery.parseJSON(data);

            if(hsl.code == '200'){
                $('#test').trigger('click');
                $('#exp_date').val(hsl.exp_date);
                $('#batch_no').val(hsl.batch_no);
                $('#sisa_stok').val(hsl.jumlah);
                
                var row = '<option value=\"\">- Pilih Item -</option>';

                $.each(hsl.items,function(i,obj){
                    row += '<option data-exp=\"'+obj.exp_date+'\" data-batch=\"'+obj.batch_no+'\" data-jumlah=\"'+obj.jumlah+'\" value=\"'+obj.stok_id+'\">'+obj.kode_barang+' | '+obj.nama_barang+' | '+obj.exp_date +' | '+obj.jumlah+'</option>';
                });
                
                $('#barang_id').append(row);
            }

            else{
                alert(hsl.message);
            } 
        }
    });
});

$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {

        e.preventDefault();
        var inputs = $(this).closest('.request-order-view').find(':input:visible');
              
        inputs.eq( inputs.index(this)+ 1 ).focus().select();
        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 10);


    }
});
});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>