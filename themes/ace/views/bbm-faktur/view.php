<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\Url;
use yii\grid\GridView;
use yii\web\JsExpression;
use kartik\date\DatePicker;
use app\models\BbmFakturItem;

$this->title = 'Faktur BBM';
$this->params['breadcrumbs'][] = ['label' => 'Bbm Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$listDataBarang=\app\models\SalesMasterBarang::getListBarangs();


?>
<div class="bbm-faktur-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
        // echo '<a href="javascript:void(0)" id="btn_dropping" class="btn btn-success">Dropping</a>';
        
        echo '&nbsp;';
        $label = '';
            $kode = 0;
            $warna = '';
            if($model->is_selesai ==1){
                $label = 'Batal Setujui';
                $kode = 2;
                $warna = 'warning';
            }

            else{
                $label = 'Setujui';
                $kode = 1;
                $warna = 'info';
            }
            echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
                'class' => 'btn btn-'.$warna,
                'data' => [
                    'confirm' => $label.' pembelian ini?',
                    'method' => 'post',
                ],
            ]);
        ?>
    </p>
<?php \yii\widgets\Pjax::begin(['id' => 'pjax-container-faktur']); ?>  
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'namaSuplier',
           
            'no_so',

            [
                'label' => 'Tgl SO',
                'value' => function($model){
                    return Yii::$app->formatter->asDate($model->tanggal_so);
                }
            ],
           
            [
                'label' => 'Total',
                'value' => function($model){
                    return $model->getHargaTotal();
                }
            ]
            // 'perusahaan.nama',
            // 'created',
        ],
    ]) ?>

      <?php \yii\widgets\Pjax::end(); ?>
      <div class="row" >
        <div class="col-xs-12">

<form class="form-horizontal">
    <div class="col-lg-12">
        
    <div class="form-group">
        <label class="col-sm-1 control-label no-padding-right">Barang</label>
        <div class="col-lg-2 col-sm-5">
             <?= Html::dropDownList('id_barang',null,$listDataBarang, ['prompt'=>'..Pilih Barang..','id'=>'id_barang','class'=>'form-control']); ?>
        </div>
        <input id="id_faktur" type="hidden" value="<?=$model->id;?>">
                <input id="id_gudang" type="hidden">
             <input id="id_barang" type="hidden">
        <label class="col-sm-1 control-label no-padding-right">Qty (liter)</label>
        <div class="col-lg-1 col-sm-5">
            <input id="jumlah" type="number" class="form-control" value="0">
        </div>
        <label class="col-sm-1 control-label no-padding-right">Harga (Rp)</label>
            <div class="col-lg-1 col-sm-5">
                <input id="harga_netto" type="number" class="form-control" value="0">
            </div>
            <label class="col-sm-1 control-label no-padding-right">PPh (Rp)</label>
            <div class="col-lg-1 col-sm-5">
                <input id="pph" type="number" min="0" max="100" class="form-control" value="0">
            </div>
            
        <div class="col-sm-2">
                <button class="btn btn-sm btn-primary" id="input-barang"><i class="fa fa-plus"></i> Tambah</button>
            </div>
    </div>
   

  
</div>
 
</form>
    
</div>
    </div>
    <p>
        <div id="alert-message" style="display: none"></div>
       
    </p>
 <?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?>  
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'showFooter'=>TRUE,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'nomor_lo',
            // 'tanggal_lo',
            'namaBarang',
            // 'satuan',

            [
                'attribute' => 'jumlah',
                'headerOptions' => ['style' => 'text-align:right'],
                'contentOptions' => ['style' => 'text-align:right'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->jumlah);
                }
            ],
            [
                'attribute' => 'harga',
                'headerOptions' => ['style' => 'text-align:right'],
                'contentOptions' => ['style' => 'text-align:right'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->harga);
                }
            ],
            [
                'attribute' => 'pph',
                'headerOptions' => ['style' => 'text-align:right'],
                'contentOptions' => ['style' => 'text-align:right'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->pph);
                }
            ],
            [
                'header' => 'Harga Gross (Rp)',
                'headerOptions' => ['style' => 'text-align:right'],
                'footerOptions' => ['style' => 'text-align:right'],
                'contentOptions' => ['style' => 'text-align:right'],
                'value' => function($model){
                    return Yii::$app->formatter->asDecimal($model->pph + $model->harga);
                },
                'footer' => BbmFakturItem::getTotal($dataProvider->models),
            ],
            // 'namaGudang',
            // 'created',

             [
                'class' => 'yii\grid\ActionColumn',
                // 'visible'=>Yii::$app->user->can('adm'),
                'template' => ' {update} {delete}',
                'buttons' => [
                    'update' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                    'onclick' => "
                                    $('#faktur-item-id').val(".$model->id.");
                                    $('#update_jumlah').val(".$model->jumlah.");
                                    $('#update_barang_id').val(".$model->barang_id.");
                                    $('#update_harga').val('".$model->harga."');
                                    $('#update_pph').val('".$model->pph."');
                                    $('#test').trigger('click');
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
                                            $('#alert-message').html('<div class=\"alert alert-success\">Data berhasil dihapus</div>');
                                            $('#alert-message').show();    
                                            $('#alert-message').fadeOut(1500);
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
                        $url =Url::to(['bbm-faktur-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['bbm-faktur-item/update','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['bbm-faktur-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
      <?php \yii\widgets\Pjax::end(); ?>
</div>

<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Data</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
]);

?>
<p>
        <div id="alert-message-modal" style="display: none"></div>
       
    </p>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah </label>

        <div class="col-sm-9">
            <input type="hidden" id="faktur-item-id"/>
            <input type="hidden" id="update_barang_id"/>
            <input type="text" id="update_jumlah" placeholder="Jumlah" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Harga </label>

        <div class="col-sm-9">
            <input type="number" id="update_harga" placeholder="Harga" class="col-xs-10 col-sm-5" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> PPh </label>

        <div class="col-sm-9">
            <input type="number" id="update_pph" placeholder="PPh" class="col-xs-10 col-sm-5" />
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
    'header' => '<h2>Dropping</h2>',
    'toggleButton' => ['label' => '','id'=>'dropping','style'=>'display:none'],
]);

?>
<p>
        <div id="alert-message-modal-dropping" style="display: none"></div>
       
    </p>

<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tanggal LO </label>
        <div class="col-sm-9">
             <?= DatePicker::widget([
            'name' => 'tanggal_lo', 
            'size' => 'lg',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Select issue date ...','id'=>'tanggal_lo'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
            
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> No LO </label>

        <div class="col-sm-9">
            <input type="hidden" id="faktur-id"/>
            <input type="text" id="no_lo" placeholder="Nomor LO" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     
    
    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-dropping">
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

$this->registerJs(' 


    
    $(document).ready(function(){

        $("#btn_dropping").click(function(){
            $("#dropping").trigger("click");
        });

        $("#btn-dropping").on("click",function(){

            
            var obj = new Object;
            obj.id = "'.$model->id.'";
            obj.no_lo = $("#no_lo").val();
            obj.tanggal_lo = $("#tanggal_lo").val();
            
            $.ajax({
                type : "POST",
                url : "/bbm-faktur/ajax-dropping",
                data : {dataFaktur:obj},
                beforeSend: function(){

                    $("#alert-message-modal").hide();
                },
                success : function(data){
                    var hsl = jQuery.parseJSON(data);
                    $.pjax.reload({container: \'#pjax-container-faktur\'});
                    $("#alert-message-modal").html("<div class=\'alert alert-"+hsl.code+"\' >"+hsl.message+"</div>");
                    $("#alert-message-modal").show();    
                    $("#alert-message-modal").fadeOut(1500);
                  
                }
            });
        });

        $("#btn-beri").on("click",function(){

            var jml_beri = $("#jumlah-beri").val();
            var keterangan = $("#ket-beri").val();

            var obj = new Object;
            obj.faktur_item_id = $("#faktur-item-id").val();
            obj.faktur_id = "'.$model->id.'";
            obj.barang_id = $("#update_barang_id").val();
            obj.jumlah = $("#update_jumlah").val();
            obj.harga = $("#update_harga").val();
            obj.pph = $("#update_pph").val();
          
            $.ajax({
                type : "POST",
                url : "/bbm-faktur-item/ajax-update-item",
                data : {dataItem:obj},
                beforeSend: function(){

                    $("#alert-message-modal").hide();
                },
                success : function(data){
                    var hsl = jQuery.parseJSON(data);

                    $.pjax.reload({container: \'#pjax-container\'});
                    $("#alert-message-modal").html("<div class=\'alert alert-"+hsl.code+"\' >"+hsl.message+"</div>");
                    $("#alert-message-modal").show();    
                    $("#alert-message-modal").fadeOut(1500);
                  
                }
            });
        });

        $("#input-barang").click(function(e){
            e.preventDefault();
            var obj = new Object;
            obj.faktur_id = "'.$model->id.'";
            obj.barang_id = $("#id_barang").val();
            
            obj.jumlah = $("#jumlah").val();
            obj.harga = $("#harga_netto").val();
            obj.pph = $("#pph").val();
            $.ajax({
                type : "POST",
                dataType : "json",

                url : "'.\yii\helpers\Url::to(['/bbm-faktur-item/ajax-create']).'",
                data : {fakturItem : obj},
                
                success : function(hsl){
                    $.pjax.reload({container: \'#pjax-container\'});
                     $("#alert-message").html("<div class=\'alert alert-"+hsl.code+"\' >"+hsl.message+"</div>");
                    $("#alert-message").show();
                    $("#alert-message").fadeOut(1500);
                   
                    
                }
            });
        });

        
    });', \yii\web\View::POS_READY);

?>