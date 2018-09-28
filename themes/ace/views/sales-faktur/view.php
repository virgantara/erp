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
    </p>
 <p>
        <div class="alert alert-success" id="alert-message" style="display: none">Data Tersimpan</div>
       
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_faktur',
            'suplier.nama',
            'no_faktur',
            'created',
            'tanggal_faktur',
            'perusahaan.nama',
        ],
    ]) ?>
    <div class="col-lg-2">
    Jumlah <input type="text" id="jumlah_barang" class="input-small"/>
</div>
<div class="col-lg-2">
Gudang
     <?= Html::dropDownList('id_gudang',null,$listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'id_gudang']); ?>
</div>
    <div class="col-lg-4">
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
            var obj = new Object;
            obj.id_faktur = '".$model->id_faktur."';
            obj.id_barang = ui.id;
            obj.id_gudang = $('#id_gudang').val();
            obj.jumlah = $('#jumlah_barang').val();
            obj.id_satuan = ui.satuan;
            $.ajax({
                type : 'POST',
                dataType : 'json',

                url : '".\yii\helpers\Url::to(['/sales-faktur-barang/ajax-create'])."',
                data : {fakturItem : obj},
                
                success : function(hsl){
                    window.location = '".\yii\helpers\Url::to(['/sales-faktur/view','id'=>$model->id_faktur])."';
                    // console.log(hsl);
                    // $.pjax({container: '#pjax-container'});
                    // $.pjax.reload({container:'#pjax-container'});
                }
            });

           
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

    <?php \yii\widgets\Pjax::begin(['id' => 'pjax-container']); ?>   
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_barang',
            
            'namaGudang',
            'namaBarang',
            'barang.harga_beli',
            'barang.harga_jual',
            'jumlah',

            //'created',
            //'id_perusahaan',
            //'id_gudang',

            [
                'class' => 'yii\grid\ActionColumn',
                // 'visible'=>Yii::$app->user->can('adm'),
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
                        $url =Url::to(['sales-faktur-barang/delete','id'=>$model->id_faktur_barang]);
                        return $url;
                    }

                }
            ],
        ],
    ]); ?>
        <?php \yii\widgets\Pjax::end(); ?>
</div>
