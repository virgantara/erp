<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>
<table width="100%">
    <tr>
        <td width="10%"></td>
        <td width="80%" style="text-align: center">
            <strong style="font-size: 18px">PEMERINTAH KABUPATEN KEDIRI<br>
            RUMAH SAKIT UMUM DAERAH (RSUD)</strong><br>
            <span style="font-size:10px">Jl. PAHLAWAN KUSUMA BANGSA NO 1 TLP (0354) 391718, 391169, 394956 FAX. 391833<BR>
            PARE KEDIRI (64213) email : rsud.pare@kedirikab.go.id</span>
        </td>
        <td width="10%"></td>
    </tr>
</table>
<hr style="height: 1px;margin: 0px">
<h4 style="text-align: center;">BON PERMINTAAN OBAT / BARANG FARMASI</h4>
<table >
    <tr>
        <td style="width: 100px">APOTEK</td>
        <td  style="width: 20px">:</td>
        <td style="width: 250px"><?=$model->departemen->nama;?></td>
    </tr>
    <tr>
        <td >TANGGAL</td>
        <td>:</td>
        <td><?=date('d-m-Y',strtotime($model->tanggal_pengajuan));?></td>
    </tr>
</table>
 <table width="100%" border="1" style="border-style: solid;border-width: thin;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Permintaan</th>
            <th>Satuan</th>
            <th>Pemberian</th>
            <th>Keterangan</th>
                            
        </tr>
    </thead>
    <tbody>
        <?php 
        $i = 0;
        foreach($dataProvider->getModels() as $item){

        ?>
        <tr>
            <td><?=($i+1);?></td>
            <td><?=$item->item->nama_barang;?></td>
            <td style="text-align: center"><?=$item->jumlah_minta;?></td>
            <td style="text-align: center"><?=$item->item->id_satuan;?></td>
            <td style="text-align: center"><?=$item->jumlah_beri;?></td>
            <td style="text-align: center"><?=$item->keterangan;?></td>
                            
        </tr>
        <?php 
        $i++;
    }
        ?>
    </tbody>
</table>
<table width="100%">
    <tr>
        <td width="33%" style="text-align: center">
            <br>Disetujui
            <br>
            Kepala Instansi Farmasi
            <br>
            <br>
            
            <br>
            <br>
            <u><b>Dra. SRI SULISTYANINGSIH, Apt.</b></u><br>
            NIP. 196306151989122001
            <br>
            <br>
            Kepala Gudang Obat
            <br>
            <br>
            
            <br>
            <br>
            <u><b>Ni'matus Sholekah, S.Farm., Apt.</b></u><br>
            NIP. 198404212010012029
        </td>
        <td width="33%" style="text-align: center">
           
        </td>
        <td width="33%" style="text-align: center">
            Pare, <?=date('d-m-Y');?>
            <br>
            Petugas Apotek
            <br>
            <br>
            
            <br>
            <br>
            <u><b>(...................................)</b></u><br>
            
            <br>
            <br>
            Petugas Gudang
            <br>
            <br>
            
            <br>
            <br>
            <u><b>(...................................)</b></u><br>
        </td>
    </tr>
</table>
<br>
<br>
<table width="100%" border="1">
    <tr>
        <td width="80%" style="text-align: center;vertical-align: top;">
            Telah diterima sesuai dengan jenis dan jumlah pemberian pada tanggal ................
            
        </td>
        <td width="20%" style="text-align: center">
             Penerima
            <br>
            <br>
            
            
            <br>
            <u><b>(...........................)</b></u><br>

        </td>
    </tr>
</table>