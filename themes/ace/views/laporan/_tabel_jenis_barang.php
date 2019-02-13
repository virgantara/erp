 <?php 
if(!empty($export)){
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_stok_jenis_barang.xls"');
            header('Cache-Control: max-age=0');

?>
    <table>
        <tr>
            <td colspan="8" style="text-align: center">
                
                <h1>Laporan Stok Jenis Barang</h1>
            </td>
        </tr>
    </table>
    <?php
}
?>

<?php 
if(!empty($results)){
foreach($list as $l){
    if(empty($results[$l->id])) continue;
?>

 <table class="table table-bordered">
     <caption><h3><?=$l->nama;?></h3></caption>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>

            <th>Sisa Stok</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Stok Akhir</th>

        </tr>
    </thead>
    <tbody>
        <?php 
        $i=0;

        foreach($results[$l->id] as $m)
        {
            $i++;
            $stok_akhir = $m['masuk'] - $m['$keluar'];
        ?>
        <tr>
            <td><?=($i);?></td>
            <td><?=$m['kode'];?></td>
            <td><?=$m['nama'];?></td>

            <td><?=$m['stok_riil'];?></td>
            <td><?=$m['masuk'];?></td>
            <td><?=$m['keluar'];?></td>
            <td><?=$stok_akhir;?></td>

        </tr>
        <?php 
            }
        
        ?>
    </tbody>
</table>
<?php 
}
}
?>