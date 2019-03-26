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

    <div class="row">
        <div class="col-md-12 ">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'kode_penjualan',
                    'namaPasien',
                    'RMPasien',
                    'jenisPasien',
                    // 'barang_id',
                    // 'satuan',
                    'tanggal',
                    
                    // 'qty',
                    // //'harga_satuan',
                    // 'harga_total',
                    'namaUnit',
                    [
                        'label' => 'Total',
                        'format' => 'raw',
                        'value'=>function($model,$url){
                            $total = \app\models\Penjualan::getTotalSubtotalBulat($model);
                            $total = ceil($total/100) * 100;
                            echo  \app\helpers\MyHelper::formatRupiah($total);
                            
                        },
                    ],
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
                        'template' => '{view} {printBayar}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                           'title'        => 'view',
                                           'data-item' => $model->id,
                                           'class' => 'view-barang',
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },
                            'printBayar' => function ($url, $model) {
                               return Html::a('<span class="glyphicon glyphicon-print"></span>', $url, [
                                           'title'        => 'Print Bukti Pembayaran',
                                            'class'=> 'print-bayar'
                                            // 'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            // 'data-method'  => 'post',
                                ]);
                            },

                        ],
                        'visibleButtons' => [
                            'printBayar' => function($model){
                                return $model->status_penjualan ;
                            }
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                    
                            if ($action === 'printBayar') {
                                $url =\yii\helpers\Url::to(['penjualan/print-bayar','id'=>$model->id]);
                                return $url;
                            }

                            else if ($action === 'view') {
                                $url =\yii\helpers\Url::to(['penjualan/view','id'=>$model->id]);
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
$script = "

function popitup(url,label,pos) {
    var w = screen.width * 0.8;
    var h = 800;
    var left = pos == 1 ? screen.width - w : 0;
    var top = pos == 1 ? screen.height - h : 0;
    
    newwindow=window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    if (window.focus) {newwindow.focus()}
    return false;
}


$(document).on('click','.print-bayar', function(e) {  // 'pjax:success' use if you have used pjax
    e.preventDefault();
    var url = $(this).attr('href');
    var id = $(this).attr('data-item');
    popitup(url,'bayar',0);
    
});


";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>