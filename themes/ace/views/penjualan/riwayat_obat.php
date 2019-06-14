<table class="table table-striped table-bordered" id="tabel-komposisi">
    <thead>
        <tr>
            <th>No</th>
            <th>No Resep</th>
            <th>Tanggal</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Racikan<br>Non-Racikan</th>
            <th style="text-align: center;">Signa 1</th>
            <th style="text-align: center;">Signa 2</th>
            <th style="text-align: center;">HJ</th>
            <th style="text-align: center;">Qty</th>
            <!-- <th style="text-align: center;">Subtotal</th> -->
            <!-- <th style="text-align: center;">Total</th> -->
        </tr>
    </thead>
    <tbody>
<?php 

    $row = '';
    $ii = 0;
    $jj = 0;
    $listKodeRacikan = [];

    foreach($results['items'] as $i => $obj)
    {

        $obj = (object)$obj;

        $row .= '<tr>';
        $row .= '<td>'.($i+1).'</td>';
        $row .= '<td>'.$obj->no_rx.'</td>';
        $row .= '<td>'.$obj->tgl.'</td>';
        $row .= '<td>'.$obj->kd.'</td>';
        $row .= '<td>'.$obj->nm.'</td>';
        $row .= $obj->is_r ? '<td>Racikan</td>' : '<td>Non-Racikan</td>';
        $row .= '<td>'.$obj->sig1.'</td>';
        $row .= '<td>'.$obj->sig2.'</td>';
        $row .= '<td>'.$obj->hj.'</td>';
        $row .= '<td>'.$obj->qty.'</td>';
        // $row .= '<td>'.$obj->sb_blt.'</td>';
        // $row .= '<td style="text-align:right">';
        // $row .= $obj->tot_lbl;
        // $row .= '</td>';
        $row .= '</tr>';

        
    }
    
    echo $row;
?>
    </tbody>
</table>
