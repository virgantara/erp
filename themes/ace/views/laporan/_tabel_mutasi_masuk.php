<?php 
if(!empty($export)){
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="laporan_mutasi.xls"');
            header('Cache-Control: max-age=0');
}
?>

<table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>Terima<br>Tgl</th>
    		<th>Dari</th>
    		<th>No<br>Faktur</th>
    		<th>Tgl<br>Faktur</th>
    		<th>Jenis<br>Surat</th>
    		<th>No</th>
            <th>Tgl</th>
            <th>Qty</th>
            <th>Nama Barang</th>
            <th>Harga Satuan<br>Rp</th>
            <th>Jumlah Harga<br>Rp</th>
            <th>Jumlah Harga<br>Faktur<br>Rp</th>
            
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;

            $i = 0;
    		foreach($dataProvider->getModels() as $key => $m)
    		{
                // $total += $model->subtotal;
    			// print_r($model);exit;
                // $subtotal = $m->harga_beli * $m->jumlah;
                $j = 0;
               

                $total_sub = 0;
                foreach($m->salesFakturBarangs as $q => $v)
                {

                    $total_sub += $m->getTotalSubtotal($m->salesFakturBarangs);    

                    $subtotal = $v->jumlah * $v->harga_beli;
                    $total += $total_sub;
                if($j==0){

                     $i++;
    		?>
    		<tr>
                <td><?=($i);?></td>
    			<td><?=date('d/m/Y',strtotime($m->tanggal_dropping));?></td>
    			<td><?=$m->suplier->nama;?></td>
    			<td><?=$m->no_faktur;?></td>
                <td><?=date('d/m/Y',strtotime($m->tanggal_faktur));?></td>
                <td></td>
                <td><?=$m->no_do;?></td>
                <td><?=date('d/m/Y',strtotime($m->tanggal_dropping));?></td>
                <td><?=$v->jumlah;?></td>
                <td><?=$v->barang->nama_barang;?></td>
                <td style="text-align: right;"><?=number_format($v->harga_beli,2,',','.');?></td>
                <td style="text-align: right;"><?=number_format($subtotal,2,',','.') ;?></td>
                <td style="text-align: right;"><?=number_format($total_sub,2,',','.');?></td>
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td><?=$v->jumlah;?></td>
                <td><?=$v->barang->nama_barang;?></td>
                <td style="text-align: right;"><?=number_format($v->harga_beli,2,',','.');?></td>
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
                <td colspan="12" style="text-align: right">Total</td>
                <td style="text-align: right"><?=number_format($total,2,',','.');?></td>
                
            </tr>
        </tfoot>
    </table>