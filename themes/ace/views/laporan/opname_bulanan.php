<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="barang-opname-form">

    <?php $form = ActiveForm::begin(); ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Namma</th>
                <th>Satuan</th>
                <th>Bln<br>Sblm</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Bln<br>Skrg</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <body>
            <?php 
            $total = 0;
            foreach($list as $q => $m)
            {
                $harga = $m->stok * $m->barang->harga_beli;

                $total += $harga;
            ?>
            <tr>
                <td><?=($q+1);?></td>
                <td><?=$m->barang->nama_barang;?></td>
                <td><?=$m->barang->nama_barang;?></td>
                <td><?=$m->barang->id_satuan;?></td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td><?=$m->stok;?></td>
                <td style="text-align: right;"><?=$m->barang->harga_beli;?></td>
                <td style="text-align: right;"><?=$harga;?></td>
            </tr>
            <?php 
            }
            ?>
        </body>
    </table>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
