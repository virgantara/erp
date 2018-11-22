<?php

use yii\helpers\Html;
use yii\helpers\Url; 
use yii\widgets\DetailView;

use \kartik\grid\GridView;
use app\models\SalesGudang;

use kartik\date\DatePicker;

$listDataGudang=SalesGudang::getListGudangs();

$this->title = $model->nama_barang.' | '.Yii::$app->name;
$this->params['breadcrumbs'][] = ['label' => 'Sales Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-master-barang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <div class="col-xs-6">
        <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_barang], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_barang], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'nama_barang',
            'harga_beli',
            'harga_jual',
            'id_satuan',
            'created',
            'perusahaan.nama',
           
        ],
    ]) ?>
</div>
<div class="col-xs-6">
     <?php
    if(!empty($model->obatDetil)){

    ?>
    <p>
        <?= Html::a('Update', ['obat-detil/update', 'id' => $model->obatDetil->id], ['class' => 'btn btn-primary']) ?>
       
    </p>
    <?php
    echo DetailView::widget([
        'model' => $model->obatDetil,
        'attributes' => [
            'nama_generik',
            'kekuatan',
            'satuan_kekuatan',
            // 'jns_sediaan',
            'b_i_r',
            'gen_non',
            'oakrl',
            'kronis'
           
        ],
    ]);
}
     ?>
</div>
 <p>
    <h3>Stok Barang di Gudang</h3>
         <?= Html::a('Create Stok', ['sales-stok-gudang/create','barang_id'=>$model->id_barang], ['class' => 'btn btn-success',
                'onclick' => "
                    $('#modal-create-stok').trigger('click');
                    return false;
                                "]) ?>
    </p>
     <p>
        <div id="alert-message" style="display: none"></div>
       
    </p>
     <?php \yii\widgets\Pjax::begin(['id' => 'pjax-container-stok-gudang']); ?> 
    <?= GridView::widget([
        'dataProvider' => $dataProviderStok,
        // 'filterModel' => $searchModel,
        'responsiveWrap' => false,
        'showFooter'=>TRUE,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'gudang.nama',
            'batch_no',
            'exp_date',
            [
             'attribute' => 'jumlah',
             'footer' => \app\models\SalesStokGudang::getTotal($dataProviderStok->models, 'jumlah'),       
           ],
            [
                'label' => 'Satuan',
                'attribute' => 'barang.id_satuan'
            ],
            [
                 'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'onclick' => "
                                    if (confirm('Are you sure you want to delete this item?')) {
                                        $.ajax('$url', {
                                            type: 'POST'
                                        }).done(function(data) {
                                            $.pjax.reload({container: '#pjax-container-stok-gudang'});
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
                                    $('#stok-item-id').val(".$model->id_stok.");
                                    $('#jumlah-stok').val(".$model->jumlah.");
                                    $('#batch_no_update').val('".$model->batch_no."');
                                    $('#exp_date_update').val('".$model->exp_date."');

                                    $('#test').trigger('click');
                                    return false;
                                ",
                                    // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    // 'data-method'  => 'post',
                        ]);
                    },
                ],
                
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                   

                   if ($action === 'delete') {
                        $url =Url::to(['sales-stok-gudang/delete','id'=>$model->id_stok]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['sales-stok-gudang/update','id'=>$model->id_stok]);
                        return $url;
                    }


                  }
            ]
            // 'harga_jual',
            
            //'created',

           
        ],
    ]); ?>   
    <?php \yii\widgets\Pjax::end(); ?>
<p>
    <h3>Harga Barang</h3>
        <?= Html::a('Create Barang Harga', ['barang-harga/create','barang_id'=>$model->id_barang], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
         'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'harga_beli',
            'harga_jual',
            [
                'attribute' => 'pilih',
                'label' => 'Status',
                'format' => 'raw',
                'value'=>function($model,$url){

                    $st = $model->pilih == 1 ? 'success' : 'danger';
                    $label = $model->pilih == 1 ? 'ok' : 'remove';
                    return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                               <span class="glyphicon glyphicon-'.$label.'"></span>
                            </button>';
                    
                },
            ],
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{pilih} {update} {delete}',
                'visibleButtons' =>
                [
                    'delete' => function ($model) {
                        return $model->pilih == 0;
                    },
                ],
                'buttons' => [
                    'delete' => function ($url, $model) {

                        $icon = '<span class="glyphicon glyphicon-trash"></span>';
                        return Html::a($icon, $url, [
                                    'title'        => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method'  => 'post',
                        ]);
                    }, 
                    'pilih' => function ($url, $model) {
                        // $st = $model->pilih == 1 ? 'ok' : 'remove';
                        $icon = '<span class="glyphicon glyphicon-edit"></span>';
                        return Html::a($icon, $url, [
                                   'title'        => 'Pilih dan Aktifkan Harga',
                                    'data-confirm' => Yii::t('yii', 'Pilih harga item ini?'),
                                    'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'pilih') {

                        $url =Url::to(['sales-master-barang/pilih-harga','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'delete') {
                        $url =Url::to(['barang-harga/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['barang-harga/update','id'=>$model->id,'barang_id'=>$model->barang_id]);
                        return $url;
                    }


                  }
            ],
        ],
    ]); ?>




</div>

<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Stok</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
    
]);

?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Stok </label>

        <div class="col-sm-9">
            <input type="hidden" id="stok-item-id"/>
            <input type="text" id="jumlah-stok" placeholder="Jumlah Stok" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Exp Date </label>
        <div class="col-sm-9">
             <?= DatePicker::widget([
            'name' => 'tanggal', 
            'size' => 'lg',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Select issue date ...','id'=>'exp_date_update'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
            
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch No</label>

        <div class="col-sm-9">

            <input type="text" id="batch_no_update" placeholder="Batch NO" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-stok">
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
    'header' => '<h2>Create Stok</h2>',
    'toggleButton' => ['label' => '','id'=>'modal-create-stok','style'=>'display:none'],
    
]);

?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Pilih Gudang </label>

        <div class="col-sm-9">

            <?=Html::dropDownList('gudang_id',null,$listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'gudang_id']);?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Nama Barang </label>

        <div class="col-sm-9">
            <input type="hidden" id="barang_id" value="<?=$model->id_barang;?>" />
            <input type="text" id="barang_nama" placeholder="Nama Barang" disabled value="<?=$model->nama_barang;?>" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Stok </label>

        <div class="col-sm-9">

            <input type="text" id="jumlah-stok-create" placeholder="Jumlah Stok" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Exp Date </label>
        <div class="col-sm-9">
             <?= DatePicker::widget([
            'name' => 'tanggal', 
            'size' => 'lg',
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            // 'value' => date('d-M-Y'),
            'options' => ['placeholder' => 'Select issue date ...','id'=>'exp_date_create'],
            'pluginOptions' => [
                'format' => 'dd-mm-yyyy',
                'todayHighlight' => true
            ]
        ]
    ) ?>
            
        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Batch No</label>

        <div class="col-sm-9">

            <input type="text" id="batch_no_create" placeholder="Batch NO" class="col-xs-10 col-sm-5" />
        </div>
    </div>

    <div class="space-4"></div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="button" id="btn-create-stok">
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
$script = "

jQuery(function($){

    $('#btn-stok').on('click',function(){

        var jml_stok = $('#jumlah-stok').val();


        item = new Object;
        item.stok_id = $('#stok-item-id').val();
        item.jml_stok = jml_stok;
        item.batch_no = $('#batch_no_update').val();
        item.exp_date = $('#exp_date_update').val();
        item.isNew = 0;
      
        $.ajax({
            type : 'POST',
            url : '/sales-stok-gudang/ajax-update-stok',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container-stok-gudang'});
                    $('#alert-message').html('<div class=\"alert alert-success\">Data berhasil dihapus</div>');
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
                    $('#test').modal('hide');
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

     $('#btn-create-stok').on('click',function(){

        var jml_stok = $('#jumlah-stok-create').val();
        var barang_id = $('#barang_id').val();
        var gudang_id = $('#gudang_id').val();


        item = new Object;
        item.barang_id = barang_id;
        item.jml_stok = jml_stok;
        item.gudang_id = gudang_id;
        item.batch_no = $('#batch_no_create').val();
        item.exp_date = $('#exp_date_create').val();
        item.isNew = 1;
      
        $.ajax({
            type : 'POST',
            url : '/sales-stok-gudang/ajax-update-stok',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container-stok-gudang'});
                    $('#alert-message').html('<div class=\"alert alert-success\">Data berhasil dihapus</div>');
                                            
                    $('#alert-message').show();    
                    $('#alert-message').fadeOut(2500);
                    $('#test').modal('hide');
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