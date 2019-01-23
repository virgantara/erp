<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;

use app\models\SalesGudang;
use yii\helpers\Url;
use yii\web\JsExpression;


$listDataGudang=SalesGudang::getListGudangs();

/* @var $this yii\web\View */
/* @var $model app\models\Retur */

$this->title = 'Retur | No Faktur: '. $model->faktur->no_faktur;
$this->params['breadcrumbs'][] = ['label' => 'Returs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="retur-view">

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

    Yii::$app->user->can('kepalaGudang')
];
// if(in_array($userRole, $acl)){
    
    // if($model->is_approved !=1){
        $label = 'Setujui Retur ini?';
        $kode = 1;
        $warna = 'info';
        echo Html::a($label, ['approve', 'id' => $model->id,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => $label.' ? Jika Anda menekan OK, maka data dalam retur akan mengurangi stok gudang.',
                'method' => 'post',
            ],
        ]);
    // }
    
// } 


?>
    </p>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'faktur.no_faktur',
            'faktur.tanggal_faktur',
            'suplier.nama',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>
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
            
            'barang.nama_barang',
            'batch_no',
            'exp_date',
            'qty',

            'keterangan',
            [
                'class' => 'yii\grid\ActionColumn',
                // 'visible'=>Yii::$app->user->can('adm'),
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function($url, $model){
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                   'title'        => 'update',
                                    'onclick' => "
                                    $('#retur-item-id').val(".$model->id.");
                                    $('#qty').val(".$model->qty.");
                                    $('#ket').val('".$model->keterangan."');
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
                        $url =Url::to(['retur-item/delete','id'=>$model->id]);
                        return $url;
                    }

                    else if ($action === 'update') {
                        $url =Url::to(['retur-item/update','id'=>$model->id,'rid'=>$model->retur_id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
    
        <?php \yii\widgets\Pjax::end(); ?>
</div>
</div>

<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Update Item</h2>',
    'toggleButton' => ['label' => '','id'=>'test','style'=>'display:none'],
]);

?>
<p>
        <div id="alert-message-pop" style="display: none"></div>
       
    </p>
<form class="form-horizontal" role="form">
    <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> QTY </label>

        <div class="col-sm-9">
            <input type="hidden" id="retur-item-id"/>
            <input type="text" id="qty" placeholder="QTY" class="col-xs-10 col-sm-5" />
        </div>
    </div>

     <div class="form-group">
        <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Keterangan </label>

        <div class="col-sm-9">
            <input type="text" id="ket" placeholder="Keterangan" class="col-xs-10 col-sm-5" />
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

        var qty = $('#qty').val();
        var keterangan = $('#ket').val();

        item = new Object;
        item.rid = $('#retur-item-id').val();
        item.keterangan = keterangan;
        item.qty = qty;

      
        $.ajax({
            type : 'POST',
            url : '/retur-item/ajax-update-item',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);

                if(hsl.code == '200'){
                    $('#w4').modal('hide');
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message-pop').html('<div class=\'alert alert-success\'> Data telah disimpan</div>');
                    $('#alert-message-pop').show();    
                    $('#alert-message-pop').fadeOut(2500);
                }

                else{
                    alert(hsl.message);
                } 
            }
        });
    });

    $('#input-barang').on('click',function(){
        var rid = $('#rid').val();
        var jml_minta = $('#jml_minta').val();
        var ket = $('#ket_barang').val();
        var barang_id = $('#barang_id').val();


        item = new Object;
        item.rid = rid;
        item.qty = jml_minta;
        item.ket = ket;
        item.barang_id = barang_id;
        
        $.ajax({
            type : 'POST',
            url : '/retur-item/ajax-create',
            data : {dataItem:item},
            beforeSend: function(){

                $('#alert-message').hide();
            },
            success : function(data){
                var hsl = jQuery.parseJSON(data);
                
                if(hsl.code == '200'){
                    
                    $.pjax({container: '#pjax-container'});
                    $('#alert-message').html('<div class=\'alert alert-success\'> Data telah disimpan</div>');
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

?>