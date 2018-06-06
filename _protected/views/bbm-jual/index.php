<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
// use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Kas;
use \kartik\grid\GridView;
use app\models\SalesBarang;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hasil Penjualan';
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

    $listBarang = SalesBarang::getListBarangs();

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

<?php 
if(!empty($_POST['bulan']))
{
    $countDispenser = count($listDispenser->models);
?>
<table class="table table-striped">
    <thead>
    <tr>
    
    <th colspan="3" style="text-align: center;"><?=$bulans[$bulan];?></th>
    
    <?php 
    $firstDispenserId=0;
    $i=0;
    foreach($listDispenser->models as $disp)
    {
        if($i==0)
            $firstDispenserId = $disp->id;

        $i++;
        // print_r($disp);
        echo '<th colspan="3" style="text-align: center;">'.$disp->nama.'</th>';
    }
    ?>
    <th colspan="3" style="text-align: center;"><?=$barang->nama_barang;?></th>
</tr>
<tr>
    <th style="text-align: center;">No</th>
    <th style="text-align: center;">Tgl</th>
    <th style="text-align: center;">Shift</th>
     <?php 
     foreach($listDispenser->models as $disp)
    {
        // print_r($disp);
        echo '<th style="text-align: center;">Akhir</th>';
        echo '<th style="text-align: center;">Awal</th>';
        echo '<th style="text-align: center;">Saldo</th>';
    }
    ?>
    <th style="text-align: center;">Total Liter</th>
    <th style="text-align: center;">Harga</th>
    <th style="text-align: center;">Total (Rp)</th>
</tr>
</thead>
<tbody>
    <?php 
    $idx = 0;
    $isFirstDate = false;
    $total_liter = 0;
    $harga = 0;
    for($i = 0;$i<31;$i++)
    {
        
        
        $tgl = str_pad(($i+1), 2, '0', STR_PAD_LEFT);
        $fulldate = $_POST['tahun'].'-'.$_POST['bulan'].'-'.$tgl;
        // $listJualPerTanggal = \app\models\BbmJual::getListJualPerTanggal($fulldate, $barang->id_barang);
        // $listShift = \app\models\BbmJual::getListJualShifts($fulldate,$barang->id_barang);

         $listMasterShift = \app\models\Shift::getDataProviderShifts();
       
            $isExist = false;
            foreach($listMasterShift->models as $shifts)
            {
                // $listPerShift = \app\models\BbmJual::getListJualPerShift($fulldate,$barang->id_barang,$shifts->id);

                // foreach ($listPerShift as $shift) 
                // {
                    # code...
                
                    $idx++;
                    // print_r($shift->one());exit;
                    
                     $subtotal_liter = 0;
                ?>
                <tr>
                <td><?=($idx);?></td>
                 <td><?=Yii::$app->formatter->asDate($fulldate);?></td>
                 <td><?=$shifts->nama;?></td>
                 
               
                <?php 
$doubleShiftJual = \app\models\BbmJual::getItemJual($fulldate, $barang->id_barang,$shifts->id,$firstDispenserId);

                $isExist = !empty($doubleShiftJual);
                    foreach($listDispenser->models as $disp)
                    {
                        
                        $model =\app\models\BbmJual::getItemJual($fulldate, $barang->id_barang,$shifts->id,$disp->id);
                        $model = !empty($model[0]) ? $model[0] : null;
                        $stok_awal = !empty($model) ? $model->stok_awal : 0;
                        $stok_akhir = !empty($model) ? $model->stok_akhir : 0;
                        $saldo = $stok_akhir - $stok_awal;
                        $subtotal_liter += $saldo;
                        
                        $harga = !empty($model) && $model->harga != 0 ? $model->harga : $harga;
                        ?>
                         <td style="text-align: right;">
                            <?=Yii::$app->formatter->asInteger($stok_akhir);?></td>
                         <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($stok_awal);?></td>
                         <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($saldo);?></td>
                        <?php
                    }

                     $total_liter += $subtotal_liter;
                    ?>
                    <td style="text-align: right;"><?=$subtotal_liter;?></td>
                     <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($harga);?></td>
                     <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($subtotal_liter * $harga);?></td>
                     </tr>
                    <?php
                // }
                if($isExist)
                {
                     $model =\app\models\BbmJual::getItemJual($fulldate, $barang->id_barang,$shifts->id,$firstDispenserId);
                     $model = !empty($model[1]) ? $model[1] : null;
                     if(empty($model)) continue;
                    ?>
                 <tr>
                <td><?=($idx);?></td>
                 <td><?=Yii::$app->formatter->asDate($fulldate);?></td>
                 <td><?=$shifts->nama;?></td>
                 
               
                <?php 
               

                               
                    foreach($listDispenser->models as $disp)
                    {
                        
                        // $model =\app\models\BbmJual::getItemJual($fulldate, $barang->id_barang,$shifts->id,$disp->id);
                        $stok_awal = !empty($model) ? $model->stok_awal : 0;
                        $stok_akhir = !empty($model) ? $model->stok_akhir : 0;
                        $saldo = $stok_akhir - $stok_awal;
                        $subtotal_liter += $saldo;
                        
                        $harga = !empty($model) && $model->harga != 0 ? $model->harga : $harga;
                        ?>
                         <td style="text-align: right;">
                            <?=Yii::$app->formatter->asInteger($stok_akhir);?></td>
                         <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($stok_awal);?></td>
                         <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($saldo);?></td>
                        <?php
                    }

                     $total_liter += $subtotal_liter;
                    ?>
                    <td style="text-align: right;"><?=$subtotal_liter;?></td>
                     <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($harga);?></td>
                     <td style="text-align: right;"><?=Yii::$app->formatter->asInteger($subtotal_liter * $harga);?></td>
                     </tr>
                    <?php
                }
      
                }


                
        
    }
    ?>
    <tr>
         <td colspan="<?=$countDispenser*3 + 3;?>" style="text-align: right"><strong>TOTAL</strong></td>
         <td style="text-align: right"><strong><?=$total_liter;?></strong></td>
         <td style="text-align: right"><strong><?=Yii::$app->formatter->asInteger($harga);?></strong></td>
         <td style="text-align: right"><strong><?=Yii::$app->formatter->asInteger($total_liter * $harga);?></strong></td>
     </tr>

</tbody>
</table>
<?php
}

else if(empty($listJualTanggal->models) && !empty($_POST['barang_id'])){
?>

<div class="alert alert-warning">Data Tidak Ditemukan</div>
<?php
}
?>


</div>
