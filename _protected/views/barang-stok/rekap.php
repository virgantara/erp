<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Kas;
use \kartik\grid\GridView;
use app\models\SalesBarang;
use app\models\BarangStok;
use app\models\BbmJual;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekapitulasi Barang';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .label-pos{
        vertical-align: top;text-align: center;
    }

    .label-pos-right{
        vertical-align: top;text-align: right;   
    }
</style>
<div class="kas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 

$form = ActiveForm::begin();
    $bulans = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    $tahuns = [];

    for($i = 2016 ;$i<=date('Y')+50;$i++)
        $tahuns[$i] = $i;

    $bulan = !empty($_POST['bulan']) ? $_POST['bulan'] : date('m');
    $tahun = !empty($_POST['tahun']) ? $_POST['tahun'] : date('Y');

    $listBarang = SalesBarang::getListBarangs();
    $datestring=$tahun.'-'.$bulan.'-01 first day of last month';
    $dt=date_create($datestring);
    $lastMonth = $dt->format('m'); //2011-02
    $lastYear = $dt->format('Y');
    
    $stokLalu = 0;
    if(!empty($_POST['barang_id']))
    {
        $stokBulanLalu = BarangStok::getStokBulanLalu($lastMonth, $lastYear, $_POST['barang_id']);
        $stokLalu = !empty($stokBulanLalu) ? $stokBulanLalu->stok : 0;
    }
    ?>

    <div class="col-xs-4 col-md-3 col-lg-2">
        
        <?= Html::dropDownList('bulan', $bulan,$bulans,['class'=>'form-control ']); ?>

    </div>
     <div class="col-xs-4 col-md-3 col-lg-2">
        
       
        <?= Html::dropDownList('tahun', $tahun,$tahuns,['class'=>'form-control']); ?>
    </div>
    <div class="col-xs-4 col-md-3 col-lg-2">
        
        <?= Html::dropDownList('barang_id',!empty($_POST['barang_id']) ? $_POST['barang_id'] : '',$listBarang,['class'=>'form-control']); ?>

    </div>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php 
    ActiveForm::end();
    ?>

<table class="table table-striped" border="1">
    <thead>
    <tr>
    <th rowspan="3" class="label-pos">Tgl</th>
    <th colspan="4" class="label-pos">Pembelian</th>
    <th colspan="2"  class="label-pos">Penjualan</th>
    <th rowspan="3" class="label-pos">Stok (Liter)</th>
  </tr>
  <tr>
    <th colspan="2" class="label-pos">Penebusan</th>
    <th rowspan="2" class="label-pos">Droping (Liter)</th>
    <th rowspan="2" class="label-pos">Sisa DO (Liter)</th>
    <th rowspan="2" class="label-pos">Volume (Liter)</th>
    <th rowspan="2" class="label-pos">Nilai (Rp)</th>
  </tr>
  <tr>
    <th class="label-pos">(Liter)</th>
    <th class="label-pos">(Rp)</th>
  </tr>
</thead>
<tbody>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="label-pos-right"><strong><?=number_format($stokLalu,0,',','.');?></strong></td>
  </tr>
    <?php 

    if(!empty($_POST['barang_id']))
    {

        $barang = SalesBarang::find()->where(['id_barang'=>$_POST['barang_id']])->one();
        for($i = 1;$i<=31;$i++)
        {
            $tgl = str_pad($i, 2, '0', STR_PAD_LEFT);
            $fulldate = $_POST['tahun'].'-'.$_POST['bulan'].'-'.$tgl;
            $m = BarangStok::getStokTanggal($fulldate, $_POST['barang_id']);
            $mjual = BbmJual::getJualTanggal($fulldate, $_POST['barang_id']);

            $saldoJual = 0;

            foreach ($mjual as $mj) {
                $saldoJual += ($mj->stok_akhir - $mj->stok_awal);
            }

            
            $stok_bulan_lalu = !empty($m) ? $m->stok_bulan_lalu : 0;
            $dropping = !empty($m) ? $m->dropping : 0;
            $stokLalu = $stokLalu - $dropping - $saldoJual;
            
    ?>  
    <tr>
    <td class="label-pos"><?=$tgl;?></td>
    <td class="label-pos-right"><?=!empty($m) ? number_format($m->tebus_liter,0,',','.') : '';?></td>
    <td class="label-pos-right"><?=!empty($m) ? number_format($m->tebus_rupiah,0,',','.') : '';?></td>
    <td class="label-pos-right"><?=!empty($m) ? number_format($m->dropping,0,',','.') : '';?></td>
    <td class="label-pos-right"><?=!empty($m) ? number_format($m->sisa_do,0,',','.') : '';?></td>
    <td class="label-pos-right"><?=number_format($saldoJual,0,',','.');?></td>
    <td class="label-pos-right"><?=number_format($saldoJual * $barang->harga_jual,0,',','.');?></td>
    <td class="label-pos-right"><?=number_format($stokLalu,0,',','.');?></td>
  </tr>
  <?php 
        }
    }
  ?>
</tbody>
</table>

</div>
