<?php
use yii\helpers\Url;
use yii\helpers\Html;
$fontfamily = 'Tahoma';
$fontSize = '20px';
$fontSizeBawah = '18px';
?>
<table width="100%" style="height: 1px;margin: 0px">
    <tr>
        <td width="10%"></td>
        <td width="80%" style="text-align: center">
            <strong style="font-size: 13px;font-family: <?=$fontfamily;?>">RSUD KABUPATEN KEDIRI</strong><br>
            <span style="font-size:9px;font-family: <?=$fontfamily;?>">Jl. PAHLAWAN KUSUMA BANGSA NO 1 TLP (0354) 391718, 391169, 394956 FAX. 391833<BR>
            PARE KEDIRI (64213) email : rsud.pare@kedirikab.go.id</span>
        </td>
        <td width="10%"></td>
    </tr>
</table>
<hr style="height: 1px;margin: 0px">
<div style="text-align: center;margin: 0px;font-size:12px;font-family: <?=$fontfamily;?>">SURAT PENGANTAR BAYAR OBAT</div>
<table style="border: 1px solid;margin-bottom: 3px;font-size: <?=$fontSizeBawah;?>;font-family: <?=$fontfamily;?>">
    <tr>
        <td style="width: 100px">No Resep</td>
        <td  style="width: 20px">:</td>
        <td style="width: 250px"><?=$model->kode_penjualan;?></td>
    </tr>
    <tr>
        <td >Tgl Resep</td>
        <td>:</td>
        <td><?=date('d-m-Y',strtotime($model->tanggal));?></td>
    </tr>

    <tr>
        <td >Tgl Cetak</td>
        <td>:</td>
        <td><?=date('d-m-Y');?></td>
    </tr>
     
</table>
<table style="border: 1px solid;font-size: <?=$fontSizeBawah;?>;font-family: <?=$fontfamily;?>">
    
     <tr>
        <td style="width: 100px" >No RM</td>
        <td style="width: 20px">:</td>
        <td style="width: 250px"><?=$model->penjualanResep->pasien_id;?></td>
    </tr>
     <tr>
        <td >Jenis Px</td>
        <td>:</td>
        <td><?=$model->penjualanResep->pasien_jenis;?></td>
    </tr>
    <tr>
        <td >Nama Px</td>
        <td>:</td>
        <td><?=$model->penjualanResep->pasien_nama;?></td>
    </tr>
    <tr>
        <td >Unit</td>
        <td>:</td>
        <td><?=$model->penjualanResep->unit_nama;?></td>
    </tr>
    <tr>
        <td >Dokter</td>
        <td>:</td>
        <td><?=$model->penjualanResep->dokter_nama;?></td>
    </tr>
    <tr>
        <td >Nominal</td>
        <td>:</td>
        <td style="font-weight: bold">Rp <?=\app\helpers\MyHelper::formatRupiah(\app\models\Penjualan::getTotalSubtotalBulat($model),2);?></td>
    </tr>
</table>
<table width="100%" style="border: 1px solid;">
      <tr>
        <td style="text-align: center">
             <barcode code="<?=$model->penjualanResep->pasien_id;?>" type="C128A" size="1.5" height="0.5"/>
        </td>
        
    </tr>
</table>
<table width="100%">
    <tr>
        
        <td width="100%" style="text-align: center;font-size:14px;font-family: <?=$fontfamily;?>">
            <br><br>
            Pare, <?=date('d-m-Y');?>
            <br>

            Petugas Apotek
           
            <br>
            <br>
            <br>
            <u><b>(<?=Yii::$app->user->identity->display_name;?>)</b></u>
            <br>
            
            
        </td>
    </tr>
</table>
