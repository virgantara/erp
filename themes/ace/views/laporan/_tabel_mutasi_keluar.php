<?php 
if(!empty($export)){
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_mutasi_keluar.xls"');
            header('Cache-Control: max-age=0');
    ?>
    <table>
        <tr>
            <td colspan="8" style="text-align: center">
                
                <h1>Laporan Tentang Pengeluaran Obat</h1>
            </td>
        </tr>
    </table>
    <?php
}
?>
<table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>No Surat</th>
            <th>Tgl</th>
    		<th>Untuk</th>
    		<th>Qty</th>
            <th>Nama Barang</th>
            <th>Harga Satuan<br>Rp</th>
            <th>Jumlah Harga<br>Rp</th>
            
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
            $i = 0;
    		foreach($dataProvider->getModels() as $key => $m)
    		{

                $j = 0;
                
                $total_sub = 0;
                foreach($m->requestOrderItems as $q => $v)
                {

                    $total_sub += $m->getTotalSubtotal($m->requestOrderItems);    

                    $subtotal = $v->jumlah_beri * $v->stok->barang->harga_beli;
                    $total += $total_sub;
                if($j==0){

$i++;
    		?>
    		<tr>
                <td><?=($i);?></td>
    			<td><?=$m->no_ro;?></td>
                <td><?=date('d/m/Y',strtotime($m->tanggal_pengajuan));?></td>
    			<td><?=$m->departemen->nama;?></td>
    			<td><?=$v->jumlah_beri;?></td>
                <td><?=$v->stok->barang->nama_barang;?></td>
                <td style="text-align: right;"><?=number_format($v->stok->barang->harga_beli,2,',','.');?></td>
                <td style="text-align: right;"><?=number_format($subtotal,2,',','.') ;?></td>
            
            </tr>
            <?php 
                }
                else{
                ?>
                <tr>
                
                <td></td>
                <td></td>
                <td></td>
                <td></td>
               

                <td><?=$v->jumlah_beri;?></td>
                <td><?=$v->stok->barang->nama_barang;?></td>
                <td style="text-align: right;"><?=number_format($v->stok->barang->harga_beli,2,',','.');?></td>
                <td style="text-align: right;"><?=number_format($subtotal,2,',','.') ;?></td>
            </tr>
                <?php 
                 }

                 $j++;
            }
                
             
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="7" style="text-align: right">Total</td>
                <td style="text-align: right"><?=number_format($total,2,',','.');?></td>
                
            </tr>
        </tfoot>
    </table>