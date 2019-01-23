 <?php 
if(!empty($export)){
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_opname.xls"');
            header('Cache-Control: max-age=0');

?>
    <table>
        <tr>
            <td colspan="8" style="text-align: center">
                
                <h1>Laporan Stok Opname Barang</h1>
            </td>
        </tr>
    </table>
    <?php
}
?>
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