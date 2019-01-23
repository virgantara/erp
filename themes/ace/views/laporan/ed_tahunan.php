<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */


$tanggal_awal = !empty($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : date('Y-m-01');
$tanggal_akhir = !empty($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : date('Y-m-t');

$this->title = 'Laporan ED per tahun ';
$this->params['breadcrumbs'][] = ['label' => 'ED', 'url' => ['laporan/ed_tahunan']];
$this->params['breadcrumbs'][] = $this->title;

$listDataGudang=\app\models\SalesGudang::getListGudangs();

// $listDepartment = \app\models\Departemen::getListDepartemens();

?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="barang-opname-form">

     <?php $form = ActiveForm::begin([
        'action' => ['laporan/ed-tahunan'],
        'options' => [
            'id' => 'form-opname',
        'class' => 'form-horizontal',
        'role' => 'form'
        ]
    ]); ?>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Gudang</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('gudang_id',!empty($_POST['gudang_id']) ? $_POST['gudang_id'] : $_POST['gudang_id'],$listDataGudang, ['prompt'=>'..Pilih Gudang..','id'=>'gudang_id']);?>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Awal</label>
         <div class="col-sm-2">
     <?= yii\jui\DatePicker::widget([
            'name' => 'tanggal_awal',
            'value' => $tanggal_awal,
            'options' => ['placeholder' => 'Pilih tanggal awal ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]);
     ?>

        </div>
    </div>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Akhir</label>
         <div class="col-sm-2">
     <?= yii\jui\DatePicker::widget([
            'name' => 'tanggal_akhir',
            'value' => $tanggal_akhir,
            'options' => ['placeholder' => 'Pilih tanggal akhir ...'],
            // 'formatter' => [
                'dateFormat' => 'php:d-m-Y',
                // 'todayHighlight' => true
            // ]
        ]
    ); ?><input type="submit" class="btn btn-success" name="btn-cari" value="Cari"/>

        </div>
    </div>

      <?php ActiveForm::end(); ?>

  

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Jumlah</th>
                <th>ED</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i=0;
            foreach($list as $m)
            {
                $i++;
            ?>
            <tr>
                <td><?=($i);?></td>
                <td><?=$m['kode'];?></td>
                <td><?=$m['nama'];?></td>
                <td><?=$m['jumlah'];?></td>
                <td><?=$m['bulan'].'-'.$m['tahun'];?></td>
                <td style="text-align: right;"><?=$m['hb'];?></td>
                <td style="text-align: right;"><?=$m['subtotal'];?></td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>
