<?php 
if($export){
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan_penjualan.xls"');
    header('Cache-Control: max-age=0');
}
?>

 <table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>Tgl</th>
    		<th>No Trx</th>
            <th>Kode</th>
    		<th>Nama</th>
    		<th>Qty</th>
    		<th>HB</th>
            <th>HJ</th>
            
            <th>Laba</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;

    		foreach($results as $key => $model)
    		{

                // print_r($model);exit;

                $laba = ($model->harga - $model->harga_beli) * $model->qty;
                $total += $laba;
                
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=date('d/m/Y',strtotime($model->penjualan->tanggal));?></td>
                <td><?=$model->penjualan->kode_penjualan;?></td>
                <td><?=$model->stok->barang->kode_barang;?></td>
    			<td><?=$model->stok->barang->nama_barang;?></td>
    			<td><?=round($model->qty,2);?></td>
                <td style="text-align: right;"><?=$export ? round($model->harga_beli,2): \app\helpers\MyHelper::formatRupiah($model->harga_beli,2);?></td>
                <td style="text-align: right;"><?=$export ? round($model->harga,2): \app\helpers\MyHelper::formatRupiah($model->harga,2);?></td>
                <td style="text-align: right;"><?=$export ? round($laba,2): \app\helpers\MyHelper::formatRupiah($laba,2);?></td>
                

    		</tr>
    		<?php 
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="8" style="text-align: right">Total Laba</td>
                <td style="text-align: right;"><?=$export ? round($total,2) : \app\helpers\MyHelper::formatRupiah($total,2);?></td>
                
            </tr>
        </tfoot>
    </table>