<?php
use yii\helpers\Url;
use yii\helpers\Html;
$fontfamily = 'Times';
$fontSize = '20px';
$fontSizeBawah = '12px';
?>
<table width="100%" style="margin: 0px" cellpadding="0">
    <tr>
        <td width="10%"></td>
        <td width="80%" style="text-align: center">
            <strong style="font-size: 10px;font-family: <?=$fontfamily;?>">INSTALASI FARMASI</strong><br>
            <span style="font-size:8px;font-family: <?=$fontfamily;?>">RSUD KABUPATEN KEDIRI</span>
        </td>
        <td width="10%"></td>
    </tr>
</table>

<table style="font-size: 16px;font-family: <?=$fontfamily;?>" cellpadding="0">
    <tr>
        <td >No Resep</td>
        <td>:</td>
        <td><?=$model->penjualan->kode_penjualan;?></td>
    </tr>
    
     <tr>
        <td >Tanggal</td>
        <td>:</td>
        <td><?=date('d/m/Y');?></td>
    </tr>
    <tr>
        <td >Nama Px</td>
        <td>:</td>
        <td><?=$model->penjualan->penjualanResep->pasien_nama;?></td>
    </tr>
     <tr>
        <td style="width: 100px" >No RM</td>
        <td style="width: 20px">:</td>
        <td style="width: 250px"><?=$model->penjualan->penjualanResep->pasien_id;?></td>
    </tr>
    
    <tr>
        <td >Nama obat</td>
        <td>:</td>
        <td><?=$is_racikan ? 'Racikan' : $model->stok->barang->nama_barang;?></td>
    </tr>
     <tr>
        <td >ED</td>
        <td>:</td>
        <td></td>
    </tr>
    <tr>
        <td >Aturan</td>
        <td>:</td>
        <td><?=$model->signa1.' x sehari '.$model->signa2;?> .........................<br>............sebelum/sesudah/bersama makan</td>
    </tr>
</table>

