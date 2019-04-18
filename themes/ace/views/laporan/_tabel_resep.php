 <?php 
if($export){
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="laporan_resep.xls"');
    header('Cache-Control: max-age=0');
}
?>
 <table class="table table-bordered table-striped">
    	<thead>
    		<tr>
            <th>No</th>
            <th>Tgl</th>
    		<th>Nama Px</th>
    		<th>No RM</th>
    		<th>No Resep</th>
    		<th>Jenis<br>Resep</th>
            <th>Poli</th>
            <th>Dokter</th>
            <th>Jumlah</th>
            <th>Jumlah ke<br>Apotik</th>
            <th>Total Jumlah</th>
    		
    	</tr>
    	</thead>
    	<tbody>
    		<?php 
            $total = 0;
    		foreach($results as $key => $model)
            {
                
                $jml_sisa = 0;
                $jml_ke_apotik = 0;
                $qty = 0;
                $sisa = 0;
                $ke_apotik = 0;
                $subtotal = 0;
                foreach($model->penjualanItems as $item)
                {
                    $qty += ceil($item->qty) * round($item->harga);
                    $tmp = ceil($item->qty) - $item->jumlah_ke_apotik;
                    $sisa += $tmp;
                    $ke_apotik += $item->jumlah_ke_apotik;
                    $jml_sisa += round($item->harga) * $tmp;
                    
                    $jml_ke_apotik += ($item->jumlah_ke_apotik * round($item->harga));
                    $subtotal += ceil($item->qty) * round($item->harga);
                }

                $total += $subtotal;

                // $sisa = ($model->qty - $model->jumlah_ke_apotik) * $model->harga;

                // $subtotal_ke_apotik = $subtotal;
                // if($model->qty != $model->jumlah_ke_apotik)
                // {
                //     $subtotal_ke_apotik = $model->jumlah_ke_apotik * $model->harga;                            
                // }

                
    		?>
    		<tr>
                <td><?=($key+1);?></td>
    			<td><?=date('d/m/Y',strtotime($model->tanggal));?></td>
                <td><?=$model->penjualanResep->pasien_nama;?></td>
    			<td><?=$model->penjualanResep->pasien_id;?></td>
    			<td><?=$model->kode_penjualan;?></td>
                <td><?=$listJenisResep[$model->penjualanResep->jenis_resep_id];?></td>
                <td><?=$model->penjualanResep->unit_nama;?></td>
                <td><?=$model->penjualanResep->dokter_nama;?></td>
                <td style="text-align: right"><?=$export ? round($jml_sisa,2): \app\helpers\MyHelper::formatRupiah($jml_sisa,2);?> </td>
                <td style="text-align: right"><?=$export ? round($jml_ke_apotik,2): \app\helpers\MyHelper::formatRupiah($jml_ke_apotik,2);?></td>
                <td style="text-align: right"><?=$export ? round($subtotal,2): \app\helpers\MyHelper::formatRupiah($subtotal,2);?></td>
                

    		</tr>
    		<?php 
    	   }
    		?>

    	</tbody>
        <tfoot>
            <tr>
                <td colspan="10" style="text-align: right">Total</td>
                <td style="text-align: right"><?=$export ? round($total,2) : \app\helpers\MyHelper::formatRupiah($total,2);?></td>
                
            </tr>
        </tfoot>
    </table>
   