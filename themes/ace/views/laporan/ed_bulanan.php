<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */


$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
$this->title = 'Laporan ED per tahun ';
$this->params['breadcrumbs'][] = ['label' => 'Stok Opname', 'url' => ['barang-opname/create']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="barang-opname-form">

     <?php $form = ActiveForm::begin([
        'action' => ['laporan/opname-bulanan'],
        'options' => [
            'id' => 'form-opname',
        'class' => 'form-horizontal',
        'role' => 'form'
        ]
    ]); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Opname</label>
        <div class="col-sm-2">
           <?= \yii\jui\DatePicker::widget([
             'options' => ['placeholder' => 'Pilih tanggal awal ...','id'=>'tanggal'],
             'name' => 'tanggal',
             'value' => $tanggal,
            'dateFormat' => 'php:d-m-Y',
        ]
    ) ?><input type="submit" class="btn btn-success" name="btn-cari" value="Cari"/>
        


        </div>
    </div>
      <?php ActiveForm::end(); ?>

  

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Bln<br>Sblm</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Bln<br>Skrg</th>
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
                <td><?=$m['satuan'];?></td>
                <td><?=$m['stok_lalu'];?></td>
                <td><?=$m['masuk'];?></td>
                <td><?=$m['keluar'];?></td>
                <td><?=$m['stok_riil'];?></td>
                <td style="text-align: right;"><?=$m['hb'];?></td>
                <td style="text-align: right;"><?=$m['hj'];?></td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
</div>
