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

<table style="font-size: 12px;font-family: <?=$fontfamily;?>" cellpadding="0">
    <tr>
        
        <td><?=$model->penjualan->kode_penjualan;?></td>
    </tr>
    
     <tr>
        <td><?=date('d/m/Y');?></td>
    </tr>
    <tr>
        <td><?=$model->penjualan->penjualanResep->pasien_nama.'/'.$model->penjualan->penjualanResep->pasien_id;?></td>
    </tr>
    
    <tr>
        <td><?=$is_racikan ? 'Racikan' : $model->stok->barang->nama_barang;?></td>
    </tr>
     <tr>
        <td></td>
    </tr>
    <tr>
        <td><?=$model->signa1.' x sehari '.$model->signa2;?> .........................<br>............sebelum/sesudah/bersama makan</td>
    </tr>
</table>

