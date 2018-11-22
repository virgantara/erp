<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\helpers\Url;
use yii\grid\GridView;
use yii\web\JsExpression;
use app\models\SalesGudang;



$listDataGudang=SalesGudang::getListGudangs();
/* @var $this yii\web\View */
/* @var $model app\models\SalesFaktur */

$this->title = 'Data Faktur No:'.$model->no_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Sales Fakturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-faktur-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_faktur], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_faktur], [
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

    Yii::$app->user->can('kepalaGudang')
];
if(in_array($userRole, $acl)){
    
    // if($model->is_approved !=1){
        $label = 'Setujui Faktur ini?';
        $kode = 1;
        $warna = 'info';
        echo Html::a($label, ['approve', 'id' => $model->id_faktur,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => $label.' ? Jika Anda menekan iya, maka data dalam faktur akan masuk ke stok gudang.',
                'method' => 'post',
            ],
        ]);
    // }
    
} 


?>
    </p>
 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id_faktur',
            'suplier.nama',
            'no_faktur',
            'created',
            'tanggal_faktur',
            'tanggal_jatuh_tempo',
            'tanggal_dropping',
            'perusahaan.nama',
        ],
    ]) ?>
      <div class="row" >
        <div class="col-xs-12">

<form class="form-horizontal">
    <div class="col-lg-6">
        
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right">Gudang</label>
        <div class="col-sm-4">
             <?= Html::dropDownList('id_gudang',null,$listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang','class'=>'form-control']); ?>
        </div>
        <label class="col-sm-2 control-label no-padding-right">Obat</label>
        <div class="col-sm-4">
             <?php 
     $url = \yii\helpers\Url::to(['/sales-stok-gudang/ajax-barang']);
    
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
           $('#jumlah').focus();
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
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right">Kode</label>
        <div class="col-sm-4">
            <input id="kode_barang" type="text" class="form-control">
        </div>
        <label class="col-sm-2 control-label no-padding-right">Barang</label>
        <div class="col-sm-4">
            <input id="id_faktur" type="hidden" value="<?=$model->id_faktur;?>">
                <input id="id_gudang" type="hidden">
                <input id="id_barang" type="hidden">
                <input id="nama_barang" type="text" class="form-control">
        </div>
    </div>
   
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right">Satuan</label>
        <div class="col-sm-4">
            <input id="id_satuan" type="text" class="form-control">
            
            
        </div>
        <label class="col-sm-2 control-label no-padding-right">Qty</label>
        <div class="col-sm-4">
            <input id="jumlah" type="number" class="form-control">
        </div>
    </div>
   
</div>
    <div class="col-lg-6">
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">Exp Date</label>
            <div class="col-sm-4">
                <input name="exp_date"  type="text" id="exp_date" />
                    
            </div>
            <label class="col-sm-2 control-label no-padding-right">Batch No.</label>
            <div class="col-sm-4">
                <input id="no_batch" type="text" class="form-control">
            </div>
        </div>
       
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">Harga Nett (Rp)</label>
            <div class="col-sm-3">
                <input id="harga_netto" type="number" class="form-control">
            </div>
            <label class="col-sm-1 control-label no-padding-right">PPn (%)</label>
            <div class="col-sm-2">
                <input id="ppn" type="number" min="0" max="100" class="form-control" >
            </div>
            <label class="col-sm-2 control-label no-padding-right">Diskon (%)</label>
            <div class="col-sm-2">
                <input id="diskon" type="number" min="0" max="100" class="form-control">
            </div>
        </div>
      
        <div class="form-group">
            <div class="col-sm-9">
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
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_barang',
            
            'namaGudang',
            'namaBarang',
            'no_batch',
            'exp_date',
            
            'jumlah',
            'id_satuan',
            'harga_netto',
            'diskon',
            'ppn',
            'harga_beli',
            'harga_jual',
            
            
            



            //'created',
            //'id_perusahaan',
            //'id_gudang',

            [
                'class' => 'yii\grid\ActionColumn',
                // 'visible'=>Yii::$app->user->can('adm'),
                'template' => '{delete}',
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
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =Url::to(['sales-faktur-barang/delete','id'=>$model->id_faktur_barang]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
    
        <?php \yii\widgets\Pjax::end(); ?>
</div>
<?php

$this->registerJs(' 


    $(document).on(\'keydown\',\'input\', function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        
        if (e.ctrlKey && e.keyCode == 13) {
            $(\'form\').submit();
        }
        else if(key == 13) {
            e.preventDefault();

            var inputs = $(this).closest(\'form\').find(\':input:visible\');
                  
            inputs.eq( inputs.index(this)+ 1 ).focus().select();
           


        }
    });

    $(document).ready(function(){
        $("#exp_date").datetextentry(); 
        
        $("#input-barang").click(function(e){
            e.preventDefault();
            var obj = new Object;
            obj.id_faktur = "'.$model->id_faktur.'";
            obj.id_barang = $("#id_barang").val();
            obj.id_gudang = $("#id_gudang").val();
            obj.jumlah = $("#jumlah").val();
            obj.harga_netto = $("#harga_netto").val();
            obj.id_satuan = $("#id_satuan").val();
            obj.ppn = $("#ppn").val();
            obj.diskon = $("#diskon").val();
            obj.exp_date = $("#exp_date").val();
            obj.no_batch = $("#no_batch").val();
            $.ajax({
                type : "POST",
                dataType : "json",

                url : "'.\yii\helpers\Url::to(['/sales-faktur-barang/ajax-create']).'",
                data : {fakturItem : obj},
                
                success : function(hsl){
                    $.pjax.reload({container: \'#pjax-container\'});
                    
                    $("#alert-message").show();
                    if(hsl.code == "success")
                        $("#kd_barang").focus();
                    $("#alert-message").html("<div class=\'alert alert-"+hsl.code+"\' >"+hsl.message+"</div>");
                    // window.location = "'.\yii\helpers\Url::to(['/sales-faktur/view','id'=>$model->id_faktur]).'";
                }
            });
        });

        
    });', \yii\web\View::POS_READY);

?>