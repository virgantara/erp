<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenjualanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penjualan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Penjualan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-sm-6">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kode_penjualan',
                    // 'barang_id',
                    // 'satuan',
                    'tanggal',
                    
                    // 'qty',
                    // //'harga_satuan',
                    // 'harga_total',
                    'departemen.nama',
                    'created_at',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {printPengantar} {printResep}',
                        'buttons' => [
                            // 'delete' => function ($url, $model) {
                            //     return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            //                'title'        => 'delete',
                            //                 'onclick' => "
                            //                 if (confirm('Are you sure you want to delete this item?')) {
                            //                     $.ajax('$url', {
                            //                         type: 'POST'
                            //                     }).done(function(data) {
                            //                         $.pjax.reload({container: '#pjax-container'});
                            //                         $('#alert-message').html('<div class=\"alert alert-success\">Data berhasil dihapus</div>');
                            //                         $('#alert-message').show();    
                            //                         $('#alert-message').fadeOut(2500);
                            //                     });
                            //                 }
                            //                 return false;
                            //             ",
                            //                 // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            //                 // 'data-method'  => 'post',
                            //     ]);
                            // },
                            'printPengantar' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, [
                                           'title'        => 'Print Pengantar',
                                            'class'=> 'print-pengantar'
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },

                            'printResep' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, [
                                           'title'        => 'Print Resep',
                                           'data-item' => $model->id,
                                           'class'=> 'print-resep'
                                            
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },

                            'view' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                           'title'        => 'view',
                                           'data-item' => $model->id,
                                           'class' => 'view-barang',
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },
                            'update' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                           'title'        => 'Update',
                                           'data-item' => $model->id,
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                    
                            if ($action === 'printPengantar') {
                                $url =\yii\helpers\Url::to(['penjualan/print-pengantar','id'=>$model->id]);
                                return $url;
                            }

                            else if ($action === 'printResep') {
                                $url =\yii\helpers\Url::to(['penjualan/print-resep','id'=>$model->id]);
                                return $url;
                            }

                            else if ($action === 'update') {
                                $url =\yii\helpers\Url::to(['penjualan/update','id'=>$model->id]);
                                return $url;
                            }

                        }
                       
                    ],
                ],
            ]); ?>
        </div>
        <div class="col-sm-6">
            <table class="table table-striped table-bordered" id="tabel-komposisi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kekuatan</th>
                        <th>Dosis Minta</th>
                        <th>Qty</th>
                        <th>Subtotal</th>

                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
$script = "


$(document).on('click','a.view-barang', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-item');
    // $('#jumlah_update').val($(this).attr('data-qty'));
    $.ajax({
        type : 'POST',
        url : '/penjualan/ajax-load-item-jual',
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
    console.log(values.rows);
    $('#tabel-komposisi > tbody').empty();
    var row = '';

    $.each(values.rows,function(i,obj){
        row += '<tr>';
        row += '<td>'+eval(i+1)+'</td>';
        row += '<td>'+obj.kode_barang+'</td>';
        row += '<td>'+obj.nama_barang+'</td>';
        row += '<td>'+obj.kekuatan+'</td>';
        row += '<td>'+obj.dosis_minta+'</td>';
        row += '<td>'+obj.qty+'</td>';
        row += '<td style=\"text-align:right\">';
        row += obj.subtotal;
        row += '</td>';
        row += '</tr>';
    });

    row += '<tr>';
    row += '<td colspan=\"6\" style=\"text-align:right\"><strong>Total Biaya</strong></td>';
    row += '<td style=\"text-align:right\"><strong>'+values.total+'</strong></td>';
    row += '<td></td>';
    row += '</tr>';

    $('#tabel-komposisi > tbody').append(row);
}

function popitup(url,label,pos) {
    var w = screen.width * 0.8;
    var h = 800;
    var left = pos == 1 ? screen.width - w : 0;
    var top = pos == 1 ? screen.height - h : 0;
    
    newwindow=window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    if (window.focus) {newwindow.focus()}
    return false;
}

$(document).on('click','.print-resep', function(e) {  // 'pjax:success' use if you have used pjax
    e.preventDefault();
    var url = $(this).attr('href');
    var id = $(this).attr('data-item');
    popitup(url,'resep',1);
    
});

$(document).on('click','.print-pengantar', function(e) {  // 'pjax:success' use if you have used pjax
    e.preventDefault();
    var url = $(this).attr('href');
    var id = $(this).attr('data-item');
    popitup(url,'pengantar',0);
    
});


";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>