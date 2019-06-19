<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
$theme = $this->theme;
/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */
$listDepartment = \yii\helpers\ArrayHelper::map(\app\models\Departemen::find()->where(['id'=>Yii::$app->user->identity->departemen])->all(),'id','nama');

$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
?>
<div class="barang-opname-form">

    <?php $form = ActiveForm::begin([
        'action' => ['barang-opname/create'],
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Opname</label>
        <div class="col-sm-2">
           <?= \yii\jui\DatePicker::widget([
             'options' => ['placeholder' => 'Pilih tanggal awal ...','id'=>'tanggal'],
             'name' => 'tanggal',
             'value' => $tanggal,
            'dateFormat' => 'php:d-m-Y',
        ]
    ) ?>
    <input type="hidden" name="cari" value="1"/>
    <input type="submit" class="btn btn-success" name="btn-cari" value="Cari"/>
        


        </div>
    </div>
      <?php ActiveForm::end(); ?>

    <?php $form = ActiveForm::begin([
        'action' => ['barang-opname/create'],
        'options' => [
            'id' => 'form-opname',
        'class' => 'form-horizontal',
        'role' => 'form'
        ]
    ]); ?>
    <input type="hidden" name="simpan" value="1"/>
    <div class="alert alert-success alert-dismissable" style="display: none" id="flash-message">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <i class="icon fa fa-check"></i>Data tersimpan
         
    </div>
<div class="row">
    <div class="col-xs-12">
        
        <button class="btn btn-success" id="btn-sync"><i class="fa fa-save"></i> Simpan</button>
         <img id="loading" src="<?=$theme->getPath('images/loading.gif');?>" style="display: none" />
    </div>
</div>
   <div class="form-group">
    <input type="hidden" name="tanggal_pilih" value="<?=!empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');?>"/>
    <input type="hidden" name="dept_id_pilih" value="<?=!empty($_POST['dept_id']) ? $_POST['dept_id'] : 0;?>"/>
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
            <?php 
            foreach($list as $q=>$m)
            {

                $date = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
                $dept_id = !empty($_POST['dept_id']) ? $_POST['dept_id'] : 0;
                $tanggal = date('d',strtotime($date));
                $bulan = date('m',strtotime($date));
                $tahun = date('Y',strtotime($date));

                 $stokOp = \app\models\BarangOpname::find()->where([
                    'departemen_stok_id' => $m->id,
                    'tahun' => $tahun.$bulan
                ])->one();

                 $stok_riil = !empty($stokOp) ? $stokOp->stok_riil : 0;
                 $selisih = $m->stok - $stok_riil;

                 $tmp_riil = $stok_riil != 0 ? $stok_riil : $m->stok;
            ?>
             <tr>
                <td><?=($q+1);?></td>
                <td><?=($m->barang->kode_barang);?></td>
                <td><?=($m->barang->nama_barang);?></td>
                <td><?=($m->barang->id_satuan);?></td>
                <td><?=($m->stok);?></td>
                <td><input value="<?=$tmp_riil;?>" type="number" style="width: 80px" data-barang_id="<?=$m->barang_id;?>" data-item="<?=$m->stok;?>" data-stok_id="<?=$m->id;?>" data-id="<?=($q+1);?>" class="stok_riil" name="stok_riil_<?=$m->id;?>"/></td>
                <td><span class="selisih"><?=$selisih;?></span></td>
            </tr>
                <?php 
            }
                ?>
                 <!-- <tr id="show_more">
                <td colspan="7" style="text-align: center;" >

                    <a class="show_more_main btn btn-info" style="width: 100%" id="show_more_main" href="javascript:void(0)">
                        <span class="show_more" title="Load more posts">Show more</span>
                        <span class="loding" style="display: none;"><span class="loding_txt">Loading...</span></span>
                    </a>

                </td>
            </tr> -->
            
        </body>
    </table>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-success" id="btn-simpan" name="btn-simpan" value="Simpan"/>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = "

function loadContent(tanggal, dept_id){
    $.ajax({
        type:'POST',
        url:'/barang-opname/ajax-loadmore',
        data:'page='+page+'&tgl='+tanggal+'&dept_id='+dept_id,
        success:function(html){
            var row = '';
            // $('.loding').hide();
            // $('.show_more').show();
            var res = $.parseJSON(html);
            // var offset = eval(res.offset);

            // if(res.empty == 1){
            //     // alert('hide');
            //     $('#show_more').hide();
            // }

            // else{
            //     $('#show_more').show();
            //     page++;
            // }


            // if(res.items.length == 0){

            $('#tabel-opname > tbody').empty();
            // }
            $.each(res.items, function(i,obj){
                consoloe.log(obj);
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
            $('#tabel-opname  > tbody').append(row);
            var nex = glob.parent().parent().next().find('td:eq(5)').find('.stok_riil').focus();
            
        }
    });
}

var page = 0;
var glob = null;
$(document).on('click','#show_more_main',function(){
    
    $('.show_more').hide();
    $('.loding').show();

    var tanggal = $('#tanggal').val() != '' ? $('#tanggal').val() : '';
    var dept_id = $('#dept_id').val() != '' ? $('#dept_id').val() : '';
    $.ajax({
        type:'POST',
        url:'/barang-opname/ajax-loadmore',
        data:'page='+page+'&tgl='+tanggal+'&dept_id='+dept_id,
        success:function(html){
            var row = '';
            // $('.loding').hide();
            // $('.show_more').show();
            // var res = $.parseJSON(html);
            // var offset = eval(res.offset);

            // if(res.empty == 1){
            //     // alert('hide');
            //     $('#show_more').hide();
            // }

            // else{
            //     $('#show_more').show();
            //     page++;
            // }


            if(res.items.length == 0){

                $('#tabel-opname > tbody').empty();
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

    // var tanggal = $('#tanggal').val() != '' ? $('#tanggal').val() : '';
    // var dept_id = $('#dept_id').val() != '' ? $('#dept_id').val() : '';
    // loadContent(tanggal, dept_id);
    
    // $('#show_more_main').trigger('click');

    $('#btn-sync').click(function(e){
        e.preventDefault();
        $('#flash-message').hide();
            $('#loading').show(); 
        $.when(
            $('.stok_riil').each(function(i,obj){
                // setTimeout(function(){
                    var barang_id = $(obj).attr('data-barang_id');
                    var stok = $(obj).attr('data-item');
                    var stok_riil = $(obj).val();
                    var stok_id = $(obj).attr('data-stok_id');
                    var tanggal = $('#tanggal').val();

                    var tmp = new Object;
                    tmp.bid = barang_id;
                    tmp.stok = stok;
                    tmp.sid = stok_id;
                    tmp.stok_riil = stok_riil;
                    tmp.tanggal = tanggal;
                    $.ajax({
                        type:'POST',
                        url:'/barang-opname/ajax-opname',
                        data:{
                            dataPost : tmp
                        },
                        async : true,
                        error : function(e){
                            console.log(e.responseText);
                        },
                        beforeSend : function(){
                            
                        },
                        success:function(html){
                           

                        }
                    });
                // },200);
            })
        )
        // .then(function(){
        //     // $('#flash-message').hide();
        //     // $('#loading').show();  
        // })
        .done(function(){
            $('#flash-message').show();
            $('#loading').hide();  
        });
        // $('#flash-message').show();
        // $('#loading').hide();   
        
    });

    $('#dept_id').change(function(){
        // page = 0;

        // var tanggal = $('#tanggal').val() != '' ? $('#tanggal').val() : '';
        // var dept_id = $('#dept_id').val() != '' ? $('#dept_id').val() : '';
        // loadContent(tanggal, dept_id);
        // $('#show_more_main').trigger('click');
    });
    $('#btn-simpan').click(function(){
        var conf = confirm('Simpan Stok Opname?');
        if(conf)
            $('#form-opname').submit();
    });

    $('#btn-cari').click(function(){
        // var conf = confirm('Simpan Stok Opname?');
        // if(conf)
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