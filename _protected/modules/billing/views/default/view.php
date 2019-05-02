<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = 'Billing Pasien : '.$model->nama.' / '.$model->custid;
$this->params['breadcrumbs'][] = ['label' => 'Tagihan', 'url' => ['/billing/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php 

        switch ($model->status_bayar) {
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
        
        echo '<div class="alert alert-'.$st.' " >
                   '.$label.'
                </div>&nbsp;';


        $label = $model->status_bayar ? '<i class="fa fa-money"></i> Batal Pembayaran' : '<i class="fa fa-money"></i> Setujui Pembayaran';
        $kode = $model->status_bayar ? 0 : 1;
        $warna = $model->status_bayar ? 'warning' : 'info';
        echo Html::a($label, ['/billing/default/bayar', 'id' => $model->id,'kode'=>$kode], [
            'class' => 'btn btn-'.$warna,
            'data' => [
                'confirm' => 'Setujui Pembayaran ini?',
                'method' => 'post',
            ],
        ]);
        echo '&nbsp;';

        if($model->status_bayar){
            echo Html::a('<span class="glyphicon glyphicon-print"></span>&nbsp;Cetak Bukti', ['print-bayar', 'id' => $model->id], [
                'class' => 'btn btn-success print-bayar',
                'data-item' =>$model->id,
                
            ]);
        }
        
        ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Total',
                'format' => 'raw',
                'value'=>function($model,$url){
                    $total = $model->nilai;
                    $total = ceil($total/100) * 100;
                    return '<label style="font-size:24px;font-weight:bold">Rp '.\app\helpers\MyHelper::formatRupiah($total).'</label>';
                    
                },
            ],
            'kode_trx',
            'nama',
            'custid',
            'jenis_customer',
            // 'tanggal',
            'issued_by',
            
            'created_at',
            
        ],
    ]) ?>

</div>
<?php
$script = "

function popitup(url,label) {
    var w = screen.width * 0.8;
    var h = screen.height * 0.5;
    var left = (screen.width  - w) / 2;
    var top = (screen.height- h) / 2;
    
    newwindow=window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    if (window.focus) {newwindow.focus()}
    return false;
}


$(document).on('click','.print-bayar', function(e) {  // 'pjax:success' use if you have used pjax
    e.preventDefault();
    var url = $(this).attr('href');
    var id = $(this).attr('data-item');
    popitup(url,'bayar');
    
});


";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>