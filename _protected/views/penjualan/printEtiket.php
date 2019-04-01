<?php
use yii\helpers\Url;
use yii\helpers\Html;
$fontfamily = 'Times';
$fontSize = '20px';
$fontSizeBawah = '12px';
?>
<table width="100%" style="margin: 0px" cellpadding="0" >
    <tr>
        <td width="10%">&nbsp;</td>
        <td width="80%" style="text-align: center">
            <span style="font-size:8px;font-family: <?=$fontfamily;?>">RSUD KABUPATEN KEDIRI</span>
        </td>
        <td width="10%">&nbsp;</td>
    </tr>
</table>

<table border="0" width="100%" style="font-size: 11px;font-family: <?=$fontfamily;?>" cellpadding="0">
    <tr>
        <td colspan="2"><?=$model->penjualan->penjualanResep->pasien_nama.'/'.$model->penjualan->penjualanResep->pasien_id;?></td>
    </tr>
    
    <tr>
        <td colspan="2"><?=$is_racikan ? 'Racikan' : $model->stok->barang->nama_barang;?></td>
    </tr>
     <tr>
        <td width="50%">Jumlah : </td>
        <td width="50%">ED : </td>
    </tr>
    <tr>
        <td width="50%">Pagi : </td>
        <td width="50%">Sore : </td>
    </tr>
    <tr>
        <td width="50%">Siang : </td>
        <td width="50%">Malam : </td>
    </tr>
    <tr>
        <td colspan="2"><?=$model->signa1.' x sehari '.$model->signa2;?> .........................</td>
    </tr>
</table>
<table border="0" width="100%" style="font-size: 11px;font-family: <?=$fontfamily;?>" cellpadding="0">
    <tr>
        <td>sebelum/sesudah/bersama makan</td>
        <td><?=date('d/m/Y');?></td>
    </tr>
</table>

