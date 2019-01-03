<?php
use yii\helpers\Url;
use yii\helpers\Html;

?>

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
            <td><?=$item->jumlah_minta;?></td>
            <td><?=$item->item->id_satuan;?></td>
            <td><?=$item->jumlah_beri;?></td>
            <td><?=$item->keterangan;?></td>
                            
        </tr>
        <?php 
        $i++;
    }
        ?>
    </tbody>
</table>
<table width="100%">
    <tr>
        <td width="40%" style="text-align: center">
            <br>Disetujui
            <br>
            Kepala Instansi Farmasi
            <br>
            <br>
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
            <br>
            <br>
            <u><b>Ni'matus Sholekah, S.Farm., Apt.</b></u><br>
            NIP. 198404212010012029
        </td>
        <td width="20%"></td>
        <td width="40%">
            Pare, <?=date('d-m-Y');?>
            <br>
            Petugas Apotek
            <br>
            <br>
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
            <br>
            <br>
            <u><b>(...................................)</b></u><br>
        </td>
    </tr>
</table>