<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */
$listDepartment = \app\models\Departemen::getListDepartemens();

$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
?>

<div class="barang-opname-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'form-opname',
        'class' => 'form-horizontal',
        'role' => 'form'
        ]
    ]); ?>
     <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Unit</label>
        <div class="col-sm-2">
          <?= Html::dropDownList('dept_id',!empty($_POST['dept_id']) ? $_POST['dept_id'] : $_POST['dept_id'],$listDepartment, ['prompt'=>'..Pilih Unit..','id'=>'dept_id']);?>

        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Bulan & Tahun</label>
        <div class="col-sm-2">
           <?= \yii\jui\DatePicker::widget([
             'options' => ['placeholder' => 'Pilih tanggal awal ...','id'=>'tanggal'],
             'name' => 'tanggal',
             'value' => $tanggal,
            'dateFormat' => 'php:d-m-Y',
        ]
    ) ?>
        </div>
    </div>
   
   <div class="form-group">
    <table class="table table-bordered" id="tabel-opname">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Stok<br>Nyata</th>
                 <th>Selisih</th>
            </tr>
        </thead>
        <body>
                 <tr id="show_more">
                <td colspan="7" style="text-align: center;" >

                    <a class="show_more_main btn btn-info" style="width: 100%" id="show_more_main" href="javascript:void(0)">
                        <span class="show_more" title="Load more posts">Show more</span>
                        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                    </a>

                </td>
            </tr>
            
        </body>
    </table>
    </div>
    <div class="form-group">
        <button type="button" class="btn btn-success" id="btn-simpan">Simpan</button>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = "

var page = 0;
var glob = null;
$(document).on('click','#show_more_main',function(){
    
    $('.show_more').hide();
    $('.loding').show();

    var tanggal = $('#tanggal').val() != '' ? $('#tanggal').val() : '';
    
    $.ajax({
        type:'POST',
        url:'/barang-opname/ajax-loadmore',
        data:'page='+page+'&tgl='+tanggal,
        success:function(html){
            var row = '';
            $('.loding').hide();
            $('.show_more').show();
            var res = $.parseJSON(html);
            var offset = eval(res.offset);

            if(res.empty == 1){
                $('#show_more').hide();
            }

            $.each(res.items, function(i,obj){
                
                var selisih = eval(obj.stok) - eval(obj.stok_riil);
                $(this).parent().next().find('.selisih').html(selisih);
                row += '<tr>';
                row += '<td>'+eval(offset)+'</td>';
                row += '<td>'+obj.kode+'</td>';
                row += '<td>'+obj.nama+'</td>';
                row += '<td>'+obj.satuan+'</td>';
                row += '<td>'+obj.stok+'</td>';
                row += '<td><input value=\"'+obj.stok_riil+'\" type=\"number\" style=\"width: 80px\" data-item=\"'+obj.stok+'\" data-id=\"'+eval(offset)+'\" class=\"stok_riil\" name=\"stok_riil_'+obj.id+'\"/></td>';
                row += '<td><span class=\"selisih\">'+selisih+'</span></td>';
                row += '</tr>';
                offset = eval(offset + 1);
            });
            $('#show_more').before(row);
            var nex = glob.parent().parent().next().find('td:eq(5)').find('.stok_riil').focus();
            
        }
    });

    page++;
});

$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
         if($(this).val()=='')
            $(this).val(0);
        var stok = isNaN($(this).attr('data-item')) ? 0 : $(this).attr('data-item');
        var stok_riil = isNaN($(this).val()) ? 0 : $(this).val();
        var selisih = eval(stok) - eval(stok_riil);
        $(this).parent().next().find('.selisih').html(selisih);
        
        var offset = $(this).attr('data-id');
        var count = $('.stok_riil').length;

        
        if(offset % 20 == 0){
            $('#show_more_main').trigger('click');
            glob = $(this);
        }



        var inputs = $(this).closest('.barang-opname-form').find(':input:visible');
              
        inputs.eq( inputs.index(this)+ 1 ).focus().select();
        $('html, body').animate({
            scrollTop: $(this).offset().top - 100
        }, 10);


    }
});

$(document).on('keydown','input', function(e) {

    var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
    
    if(key == 13) {
        e.preventDefault();
        
        
    }
});

$(document).ready(function(){

    $('#show_more_main').trigger('click');


    $('#btn-simpan').click(function(){
        var conf = confirm('Simpan Stok Opname?');
        if(conf)
            $('#form-opname').submit();
    });
});
";
$this->registerJs(
    $script,
    \yii\web\View::POS_READY
);
// $this->registerJs($script);
?>