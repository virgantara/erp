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
        <?= Html::a('Create Penjualan', ['create','jenis_rawat'=>'1'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kode_penjualan',
                    'RMPasien',
                    // 'barang_id',
                    // 'satuan',
                    'tanggal',
                    
                    // 'qty',
                    // //'harga_satuan',
                    // 'harga_total',
                    'namaUnit',
                    'created_at',
                     [
                        'attribute' => 'status_penjualan',
                        'label' => 'Status',
                        'format' => 'raw',
                        'filter'=>["1"=>"SUDAH BAYAR","0"=>"BELUM BAYAR","2"=>"BON"],
                        'value'=>function($model,$url){

                            $st = '';
                            $label = '';

                            switch ($model->status_penjualan) {
                                case 1:
                                    $label = 'SUDAH BAYAR';
                                    $st = 'success';
                                    break;
                                case 2:
                                    $label = 'BON';
                                    $st = 'warning';
                                    break;
                                default:
                                    $label = 'BELUM BAYAR';
                                    $st = 'danger';
                                    break;
                            }
                            
                            return '<button type="button" class="btn btn-'.$st.' btn-sm" >
                                       <span>'.$label.'</span>
                                    </button>';
                            
                        },
                    ],
                    

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {bayar} {update} {printPengantar} {printResep}',
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

                            'bayar' => function ($url, $model) {
                               return Html::a('<span class="fa fa-money"></span>', $url, [
                                           'title'        => 'Bayar',
                                            'class'=> 'bayar'
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
                        'visibleButtons' => [
                            'bayar' => function ($model) {
                                return !empty($model->penjualanResep) ? $model->penjualanResep->jenis_rawat == 2 && $model->penjualanResep->pasien_jenis == 'UMUM' : false;
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                    
                            if ($action === 'printPengantar') {
                                $url =\yii\helpers\Url::to(['penjualan/print-pengantar','id'=>$model->id]);
                                return $url;
                            }

                            else if ($action === 'bayar') {
                                $url =\yii\helpers\Url::to(['penjualan/view','id'=>$model->id]);
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

                            else if ($action === 'view') {
                                $url ='javascript:void(0)';
                                return $url;
                            }

                        }
                       
                    ],
                ],
            ]); ?>
        </div>
       
    </div>
</div>

<?php 

\yii\bootstrap\Modal::begin([
    'header' => '<h2>Komposisi</h2>',
    'size' => 'modal-lg',
    'toggleButton' => ['label' => '','id'=>'modal-view','style'=>'display:none'],
    
]);

?>
<table class="table table-striped table-bordered" id="tabel-komposisi">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Signa 1</th>
            <th>Signa 2</th>
            <!-- <th>Kekuatan</th> -->
            <th>Dosis<br>Minta</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>
<?php

\yii\bootstrap\Modal::end();
?>

<?php
$script = "
function popup(url,label) {
    var w = screen.width * 0.6;
    var h = screen.height * 0.6;
    var left = (screen.width  - w) / 2;
    var top = (screen.height - h) / 2;
    
    newwindow=window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    if (window.focus) {newwindow.focus()}
    return false;
}



$(document).on('click','a.view-barang', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-item');
    var url = '/penjualan/komposisi/'+id;
    popup(url,'Komposisi');
    // alert(url);
    // $('#jumlah_update').val($(this).attr('data-qty'));

});

function refreshTable(values){
    console.log(values.rows);
    $('#tabel-komposisi > tbody').empty();
    var row = '';

    var ii = 0;
    var jj = 0;
    var listKodeRacikan = [];
    $.each(values.rows,function(i,obj){
        if(obj.is_racikan=='1'){

            
            
            if(ii == 0){
                row += '<tr><td colspan=\"8\" style=\"text-align:left\">Racikan</td></tr>'
            }
            ii++;
            row += '<tr>';
            row += '<td>'+eval(i+1)+'</td>';
            row += '<td>'+obj.kode_barang+'</td>';
            row += '<td>'+obj.nama_barang+'</td>';
            row += '<td>'+obj.signa1+'</td>';
            row += '<td>'+obj.signa2+'</td>';
            
            row += '<td>'+obj.dosis_minta+'</td>';
            row += '<td>'+obj.qty_bulat+'</td>';
            row += '<td style=\"text-align:right\">';
            row += obj.subtotal_bulat;
            row += '</td>';
            
            if(!listKodeRacikan.includes(obj.kode_racikan)){
                listKodeRacikan.push(obj.kode_racikan);
                row += '<td><a href=\"javascript:void(0)\" class=\"print-etiket\" data-item=\"'+obj.id+'>\"><i class=\"glyphicon glyphicon-print\"></i></a></td>';
            }

            else
                row += '<td></td>';
            
           
            row += '</tr>';
        }

        else{
            if(jj == 0){
                row += '<tr><td colspan=\"8\" style=\"text-align:left\">Non-Racikan</td></tr>'
            }
            jj++;
             row += '<tr>';
            row += '<td>'+eval(i+1)+'</td>';
            row += '<td>'+obj.kode_barang+'</td>';
            row += '<td>'+obj.nama_barang+'</td>';
            row += '<td>'+obj.signa1+'</td>';
            row += '<td>'+obj.signa2+'</td>';
            
            row += '<td>'+obj.dosis_minta+'</td>';
            row += '<td>'+obj.qty_bulat+'</td>';
            row += '<td style=\"text-align:right\">';
            row += obj.subtotal_bulat;
            row += '</td>';
            row += '<td><a href=\"javascript:void(0)\" class=\"print-etiket\" data-item=\"'+obj.id+'\"><i class=\"glyphicon glyphicon-print\"></i></a></td>';
            row += '</tr>';
        }
    });

    row += '<tr>';
    row += '<td colspan=\"7\" style=\"text-align:right\"><strong>Total Biaya</strong></td>';
    row += '<td style=\"text-align:right\"><strong>'+values.total+'</strong></td>';
    
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


$(document).on('click','a.print-etiket', function(e) {

    var id = $(this).attr('data-item');
    var urlResep = '/penjualan/print-etiket?id='+id;
    popitup(urlResep,'Etiket',0);
    
});

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