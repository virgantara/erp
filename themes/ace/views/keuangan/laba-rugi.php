<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Kas;
use \kartik\grid\GridView;

use app\models\Saldo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Laba Rugi | '.Yii::$app->params['shortname'];
$this->params['breadcrumbs'][] = $this->title;
?>
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

    ?>

    <div class="col-xs-4 col-md-3 col-lg-2">
        
        <?= Html::dropDownList('bulan', $bulan,$bulans,['class'=>'form-control ']); ?>

    </div>
     <div class="col-xs-4 col-md-3 col-lg-2">
        
       
        <?= Html::dropDownList('tahun', $tahun,$tahuns,['class'=>'form-control ']); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php 
    ActiveForm::end();    
    ?>
<h4>Pendapatan</h4>
<table class="table table-striped" >
    <thead>
    <tr>
        <th>No Akun</th>
        <th>Keterangan</th>
        <th style="text-align:right;">Nilai</th>
    </tr>
   
    </thead>
    <tbody>
    <?php 
    $total_biaya = 0;
    foreach($pendapatan as $p)
    {
        $total_biaya += $p['total'];
    ?>
    <tr>
        <td><?=$p['kode'];?></td>
        <td><?=$p['nama'];?></td>
        <td style="text-align: right"><?=Yii::$app->formatter->asDecimal($p['total']);?></td>
        
    </tr>
    <?php 
    }

    $laba = $total_biaya;
    ?>
    <tr>
        <th colspan="2" style="text-align: right">Total Pendapatan Usaha</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($total_biaya);?></th>
    </tr>
   
    </tbody>    
</table>

<h4>Biaya Atas Pendapatan</h4>
<table class="table table-striped" >
    <thead>
    <tr>
        <th>No Akun</th>
        <th>Keterangan</th>
        <th style="text-align:right;">Nilai</th>
    </tr>
   
    </thead>
    <tbody>
    <?php 
    $total_biaya = 0;
    foreach($biayaAtasPendapatan as $p)
    {
        $total_biaya += $p->kas_keluar;
    ?>
    <tr>
        <td><?=$p->perkiraan->kode;?></td>
        <td><?=$p->keterangan;?></td>
        <td style="text-align: right"><?=Yii::$app->formatter->asDecimal($p->kas_keluar);?></td>
        
    </tr>
    <?php 
    }

    $laba = $laba - $total_biaya;
    ?>
    <tr>
        <th colspan="2" style="text-align: right">Total Biaya Atas Pendapatan</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($total_biaya);?></th>
    </tr>
     <tr>
        <th colspan="2" style="text-align: right">Laba/Rugi Kotor</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($laba);?></th>
    </tr>   
    </tbody>    
</table>

<h4>Pengeluaran Operasional</h4>
<table class="table table-striped" >
    <thead>
    <tr>
        <th>No Akun</th>
        <th>Keterangan</th>
        <th style="text-align:right;">Nilai</th>
    </tr>
   
    </thead>
    <tbody>
    <?php 
    $total_biaya = 0;
    foreach($biayaOperasional as $p)
    {
        $total_biaya += $p->kas_keluar;
    ?>
    <tr>
        <td><?=$p->perkiraan->kode;?></td>
        <td><?=$p->keterangan;?></td>
        <td style="text-align: right"><?=Yii::$app->formatter->asDecimal($p->kas_keluar);?></td>
        
    </tr>
    <?php 
    }

    $laba = $laba - $total_biaya;
    ?>
    <tr>
        <th colspan="2" style="text-align: right">Total Biaya Operasional</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($total_biaya);?></th>
    </tr>
     <tr>
        <th colspan="2" style="text-align: right">Laba/Rugi Operasional</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($laba);?></th>
    </tr>   
    </tbody>    
</table>



<h4>Pendapatan Lain</h4>
<table class="table table-striped" >
    <thead>
    <tr>
        <th>No Akun</th>
        <th>Keterangan</th>
        <th style="text-align:right;">Nilai</th>
    </tr>
   
    </thead>
    <tbody>
    <?php 
    $total_biaya = 0;
    foreach($pendapatanLain as $p)
    {
        $total_biaya += $p->kas_masuk;
    ?>
    <tr>
        <td><?=$p->perkiraan->kode;?></td>
        <td><?=$p->keterangan;?></td>
        <td style="text-align: right"><?=Yii::$app->formatter->asDecimal($p->kas_masuk);?></td>
        
    </tr>
    <?php 
    }

     $laba = $laba + $total_biaya;
   
    ?>
    <tr>
        <th colspan="2" style="text-align: right">Total Pendapatan Lain</th>
       <th style="text-align: right"><?=Yii::$app->formatter->asDecimal($total_biaya);?></th>
    </tr>
     <tr>
        <th colspan="2" style="text-align: right"><h4>Laba/Rugi Bersih</h4></th>
       <th style="text-align: right"><h4><?=Yii::$app->formatter->asDecimal($laba);?></h4></th>
    </tr>   
    </tbody>    
</table>
</div>
