<table class="table table-striped table-bordered" id="tabel-komposisi">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Signa 1</th>
            <th>Signa 2</th>
            
            <th>Dosis<br>Minta</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
<?php 

    $row = '';
    $ii = 0;
    $jj = 0;
    $listKodeRacikan = [];

    foreach($results['rows'] as $i => $obj)
    {

        $obj = (object)$obj;
        if($obj->is_racikan=='1')
        {
            
            if($ii == 0){
                $row .= '<tr><td colspan="8" style="text-align:left">Racikan</td></tr>';
            }
            $ii++;
            $row .= '<tr>';
            $row .= '<td>'.($i+1).'</td>';
            $row .= '<td>'.$obj->kode_barang.'</td>';
            $row .= '<td>'.$obj->nama_barang.'</td>';
            $row .= '<td>'.$obj->signa1.'</td>';
            $row .= '<td>'.$obj->signa2.'</td>';
            $row .= '<td>'.$obj->dosis_minta.'</td>';
            $row .= '<td>'.$obj->qty_bulat.'</td>';
            $row .= '<td style="text-align:right">';
            $row .= $obj->subtotal_bulat;
            $row .= '</td>';
            
            if(!in_array($obj->kode_racikan, $listKodeRacikan)){
                $listKodeRacikan[] = $obj->kode_racikan;
                $row .= '<td><a href="javascript:void(0)" class="print-etiket" data-item="'.$obj->id.'>"><i class="glyphicon glyphicon-print"></i></a></td>';
            }

            else
                $row .= '<td></td>';
            
           
            $row .= '</tr>';
        }

        else{
            if($jj == 0){
                $row .= '<tr><td colspan="8" style="text-align:left">Non-Racikan</td></tr>';
            }
            $jj++;
             $row .= '<tr>';
            $row .= '<td>'.($i+1).'</td>';
            $row .= '<td>'.$obj->kode_barang.'</td>';
            $row .= '<td>'.$obj->nama_barang.'</td>';
            $row .= '<td>'.$obj->signa1.'</td>';
            $row .= '<td>'.$obj->signa2.'</td>';
            $row .= '<td>'.$obj->dosis_minta.'</td>';
            $row .= '<td>'.$obj->qty_bulat.'</td>';
            $row .= '<td style="text-align:right">';
            $row .= $obj->subtotal_bulat;
            $row .= '</td>';
            $row .= '<td><a href="javascript:void(0)" class="print-etiket" data-item="'.$obj->id.'"><i class="glyphicon glyphicon-print"></i></a></td>';
            $row .= '</tr>';
        }

        
    }
    $row .= '<tr>';
    $row .= '<td colspan="7" style="text-align:right"><strong>Total Biaya</strong></td>';
    $row .= '<td style="text-align:right"><strong>'.$results['total'].'</strong></td>';
    $row .= '</tr>';
    echo $row;
?>
    </tbody>
</table>

<?php
$script = "
function popitup(url,label) {
    var w = screen.width * 0.7;
    var h = screen.height * 0.6;
    var left = (screen.width - w) / 2;
    var top = (screen.height - h) / 2;
    
    newwindow=window.open(url,label,'height='+h+',width='+w+',top='+top+',left='+left);
    if (window.focus) {newwindow.focus()}
    return false;
}

$(document).on('click','a.print-etiket', function(e) {

    var id = $(this).attr('data-item');
    var urlResep = '/penjualan/print-etiket?id='+id;
    popitup(urlResep,'Etiket',0);
    
});



";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>