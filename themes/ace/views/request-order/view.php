<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\RequestOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Request Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-order-view">

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
        if(Yii::$app->user->can('gudang')){
            $label = '';
            $kode = 0;
            $warna = '';
            if($model->is_approved ==1){
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
                    'confirm' => $label.' permintaan ini?',
                    'method' => 'post',
                ],
            ]);
    } 
    ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'no_ro',
            'petugas1',
            'petugas2',
            'tanggal_pengajuan',
            'tanggal_penyetujuan',
            'perusahaan_id',
            'created',
        ],
    ]) ?>
    <div class="row" >
        <div class="col-xs-12">
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Data</th>
            <th>Kode</th>
            <th>Barang</th>
            <th>Jml minta</th>
            <th>Satuan</th>
            <th>Opsi</th>
        </tr>
        <tr>
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
      <p>
        <?php 
    //      if(Yii::$app->user->can('operatorApotik')) {
    //     echo Html::a('Create Request Order Item', ['/request-order-item/create','ro_id'=>$model->id], ['class' => 'btn btn-success']);
    // }
         ?>
    </p>

     <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'stok.barang.nama_barang',
            'jumlah_minta',
            'jumlah_beri',
            'satuan',
            'keterangan',
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method'  => 'post',
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

                    else if ($action === 'view') {
                        $url =Url::to(['request-order-item/view','id'=>$model->id]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
</div>

<?php
$script = <<< JS

jQuery(function($){

    $('#input-barang').on('click',function(){

        $.ajax({
            type : "POST",
            url : '/request-order-item/ajax-create',
            data : 'ro_id='+$('#ro_id').val()+'&stok_id='+$('#id_stok').val()+'&jml='+$('#jml_minta').val()+'&item_id='+$('#item_id').val(),
            success : function(data){
                
                location.reload(); 
            }
        });
    });

});

JS;
$this->registerJs($script);
?>