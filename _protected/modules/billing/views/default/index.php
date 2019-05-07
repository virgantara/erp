<?php 
use yii\helpers\Html;
$this->title = 'Tagihan Pasien';
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="billing-default-index">
    <div class="row">
        <div class="col-xs-12">
            <form class='form-horizontal'>
                <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> No RM atau Trx Code:</label>
                    <div class="col-lg-2 col-sm-10">
                        <input type="text" name="search" id="search"/>    
                    </div>
                </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"></label>
                    <div class="col-lg-2 col-sm-10">
                     <?= Html::button(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','id'=>'btn-search','value'=>1]) ?>    
                        
                    </div>
                </div>
               
            </form>
            <table class="table table-striped" id="table_billing">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Trx Code</th>
                        <th>No Reg.</th>
                        <th>Cust. Name</th>
                        <th>Cust. Type</th>
                        <th>Issued By</th>
                        
                        <th>Issued Date</th>

                        <th>Status</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
$script = "

function loadTagihan(limit, page,search){
    $.ajax({
        type:'POST',
        url:'/billing/default/list-tagihan',
        data:'page='+page+'&limit='+limit+'&search='+search,
        success:function(html){
            var row = '';
            
            var res = $.parseJSON(html);
            let label = '';
            let st = '';
            $('#table_billing > tbody').empty();
            
            $.each(res, function(i,obj){

                row += '<tr>';
                row += '<td>'+eval(i+1)+'</td>';
                row += '<td>'+obj.kode_trx+'</td>';
                row += '<td>'+obj.custid+'</td>';
                
                row += '<td>'+obj.nama+'</td>';
                row += '<td>'+obj.jenis_customer+'</td>';
                
                row += '<td>'+obj.issued_by+'</td>';
                row += '<td>'+obj.trxdate+'</td>';
                switch (obj.status_bayar) {
                    case 1:
                        label = 'SUDAH BAYAR';
                        st = 'success';
                        break;
                    case 2:
                        label = 'BON';
                        st = 'warning';
                        break;
                    default:
                        label = 'BELUM BAYAR';
                        st = 'danger';
                        
                }
                
                let state =  '<button type=\"button\" class=\"btn btn-'+st+' btn-sm\" ><span>'+label+'</span></button>';

                row += '<td>'+state+'</td>';
                row += '<td><a href=\"/billing/default/view?id='+obj.id+'\"><button class=\"btn btn-info btn-sm \"><span class=\"glyphicon glyphicon-eye-open\"></span>&nbsp;Lihat Detil</button></a></td>';
                row += '</tr>';

            });
            $('#table_billing  > tbody').append(row);
            
        }
    });
}

$(document).ready(function(){

    $('#btn-search').click(function(){
        let search = $('#search').val();
        loadTagihan(20,1,search);
    });

    $('#search').keydown(function(e){
        let key = e.keyCode;

        if(key == 13){
            e.preventDefault();
            let search = $(this).val();
            loadTagihan(20,1,search);    
        }
        
    });

    loadTagihan(20,1,'');
});


";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);


?>