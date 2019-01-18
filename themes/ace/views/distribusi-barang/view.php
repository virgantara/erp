<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

use yii\grid\GridView;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\DistribusiBarang */

$this->title = 'Distrubusi |'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Distribusi Barangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="distribusi-barang-view">

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

$url = '';
$userRole = Yii::$app->user->identity->access_role;
$acl = [
    Yii::$app->user->can('gudang'),
    Yii::$app->user->can('distributor'),
    Yii::$app->user->can('operatorUnit')
];
if(in_array($userRole, $acl)){
    
    // if($model->is_approved !=1){
        $label = 'Setujui Distribusi';
        $kode = 1;
        $warna = 'info';
        echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => $label.' distribusi ini?',
                'method' => 'post',
            ],
        ]);
    // }
    
} 


?>
    </p>



<div class="row">
    <div class="col-xs-6">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'departemenTo.nama',
            'tanggal',
            
        ],
    ]) ?>
</div>
</div>
    <div class="row" >
        <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Data</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Satuan</th>
            <th>Jml Beri</th>
            
            <th>Opsi</th>
        </tr>
        <tr>
            <td width="30%">
<?php 
     $url = \yii\helpers\Url::to(['/departemen-stok/ajax-stok-barang']);
    
    $template = '<div><p class="repo-language">{{nama}}</p>' .
    '<p class="repo-name">{{kode}}</p>';
    echo \kartik\typeahead\Typeahead::widget([
    'name' => 'kd_barang',
    'value' => '',
    'options' => ['placeholder' => 'Ketik nama barang ...',],
    'pluginOptions' => ['highlight'=>true],
    'pluginEvents' => [
        "typeahead:select" => "function(event,ui) { 
           $('#id_barang').val(ui.id); 
           $('#kode_barang').val(ui.kode);
           $('#nama_barang').val(ui.nama);
           $('#id_satuan').val(ui.satuan);
           $('#id_stok').val(ui.dept_stok_id);
           $('#jml_beri').focus();
        }",
    ],
    
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            // 'prefetch' => $baseUrl . '/samples/countries.json',
            'remote' => [
                'url' => $url . '?q=%QUERY',
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
                <input id="dist_id" type="hidden" value="<?=$model->id;?>">
                <input id="id_stok" type="hidden">

                <input id="nama_barang" type="text" class="form-control">
            </td>
            <td ><input id="id_satuan" type="text" class="form-control"></td>
            <td ><input id="jml_beri" type="text" class="form-control"></td>
            
            <td><button class="btn btn-sm btn-primary" id="input-barang"><i class="fa fa-plus"></i> Input</button></td>
        </tr>
    </table>
</div>
    </div>
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
            'stok.barang.nama_barang',
            
            'qty',
            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {update} {delete}',
                // 'visibleButtons' => [
                //     'view' => function($data){
                //         return !Yii::$app->user->can('kepalaCabang');
                //     },
                //     'update' => function($data){
                //         return $data->ro->departemen_id != Yii::$app->user->identity->departemen;
                //     },
                //     'delete' => function($data){
                //        return !Yii::$app->user->can('kepalaCabang');
                //     },
                // ],
                'buttons' => [
                    'update' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                    'onclick' => "
                                    $('#dist-barang-id').val(".$model->id.");
                                    $('#jumlah-beri').val(".$model->qty.");
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
                        $url =Url::to(['distribusi-barang-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['distribusi-barang-item/update','id'=>$model->id,'distribusi_barang_id'=>$model->distribusi_barang_id]);
                        return $url;
                    }

                    else if ($action === 'view') {
                        $url =Url::to(['distribusi-barang-item/view','id'=>$model->id]);
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
    'header' => '<h2>Konfirmasi Pemberian</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
]);

?>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Jumlah Beri </label>

        <div class="col-sm-9">
            <input type="hidden" id="dist-barang-id"/>
            <input type="text" id="jumlah-beri" placeholder="Jumlah Beri" class="col-xs-10 col-sm-5" />
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
$script = "

jQuery(function($){

    $('#btn-beri').on('click',function(){

        var jml_beri = $('#jumlah-beri').val();
        
        item = new Object;
        item.dist_id = $('#dist-barang-id').val();

        item.jml_beri = jml_beri;
      
        $.ajax({
            type : 'POST',
            url : '/distribusi-barang-item/ajax-update-item',
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
        var distribusi_barang_id = $('#dist_id').val();
        var stok_id = $('#id_stok').val();
        var jml_beri = $('#jml_beri').val();
        

        item = new Object;
        item.dist_barang_id = distribusi_barang_id;
        item.stok_id = stok_id;
        item.jml_beri = jml_beri;
        
        $.ajax({
            type : 'POST',
            url : '/distribusi-barang-item/ajax-create',
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
</div>
