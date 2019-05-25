<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\widgets\Menu;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use kartik\nav\NavX;
use yii\helpers\Url;

AppAsset::register($this);

$theme = $this->theme;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head(); ?>
</head>
<body class="no-skin">
    

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

         
            <div class="main-content">
                <div class="main-content-inner">
                   
                    <div class="page-content">
                        

                     <div class="row">
                            <div class="col-xs-12">
                                <!-- PAGE CONTENT BEGINS -->
                                <div class="invisible">
                                    <button data-target="#sidebar2" type="button" class="pull-left menu-toggler navbar-toggle">
                                        <span class="sr-only">Toggle sidebar</span>

                                        <i class="ace-icon fa fa-dashboard white bigger-125"></i>
                                    </button>

                                   
                                </div>

                                <?=$content;?>
                                <!-- PAGE CONTENT ENDS -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.page-content -->
                </div>
            </div><!-- /.main-content -->

          

            <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
                <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
            </a>
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
      
        <!-- <![endif]-->

        <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
        
        
        <!-- page specific plugin scripts -->

        <!-- ace scripts -->
        
        <!-- inline scripts related to this page -->
        <?php $this->endBody() ?>
<script type="text/javascript">

function ajaxCountNotif(){
    $.ajax({
        async : true,
        url : '<?=Url::to('/notif/ajax-count-notif');?>',
        beforeSend: function(){
            
        },
        success : function(data){
            var hsl = jQuery.parseJSON(data);
            
            $('#count-notif').html(hsl.jumlah);
        }
    });
}

function ajaxLoadNotif(){
     $.ajax({
        async : true,
        url : '<?=Url::to('/notif/ajax-notif');?>',
        beforeSend: function(){
            
        },
        success : function(data){
            $('#notif-content').empty();
            var hsl = jQuery.parseJSON(data);
            var row = '';
            $.each(hsl, function(i, obj){
                console.log(obj.url);
               row += '<li>';
               row +=     '<a href="'+obj.url+'">';
               row +=     '<div class="clearfix"><span class="pull-left"><i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>'+obj.keterangan+'</span><span class="pull-right badge badge-success">';
                // row += obj.jumlah;
                row += '</span></div></a></li>';
            });

            $('#notif-content').append(row);
        }
    });

}


    jQuery(function($) {
        setInterval(function() {
            // ajaxCountNotif();
        }, 1000);
        $('#notif-toggle').on('click',function(){
             ajaxLoadNotif();
        });

        $('#sidebar2').insertBefore('.page-content');
        $('#navbar').addClass('h-navbar');
        $('.footer').insertAfter('.page-content');

        $('.page-content').addClass('main-content');

        $('.menu-toggler[data-target="#sidebar2"]').insertBefore('.navbar-brand');


        $(document).on('settings.ace.two_menu', function(e, event_name, event_val) {
         if(event_name == 'sidebar_fixed') {
             if( $('#sidebar').hasClass('sidebar-fixed') ) $('#sidebar2').addClass('sidebar-fixed')
             else $('#sidebar2').removeClass('sidebar-fixed')
         }
        }).triggerHandler('settings.ace.two_menu', ['sidebar_fixed' ,$('#sidebar').hasClass('sidebar-fixed')]);

        $('#sidebar2[data-sidebar-hover=true]').ace_sidebar_hover('reset');
        $('#sidebar2[data-sidebar-scroll=true]').ace_sidebar_scroll('reset', true);
    })
</script>
</body>

</html>
<?php $this->endPage() ?>
