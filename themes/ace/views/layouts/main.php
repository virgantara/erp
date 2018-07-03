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
    <link href='https://fonts.googleapis.com/css?family=Ubuntu:400,700' rel='stylesheet' type='text/css'>
    <?php $this->head(); ?>
</head>
<body class="no-skin">
     <div id="navbar" class="navbar navbar-default    navbar-collapse       h-navbar ace-save-state">
            <div class="navbar-container ace-save-state" id="navbar-container">
                <div class="navbar-header pull-left">
                    <a href="#" class="navbar-brand">
                        <small>
                            <i class="fa fa-leaf"></i>
                            <?= Yii::$app->name ?>
                        </small>
                    </a>

                    <button class="pull-right navbar-toggle navbar-toggle-img collapsed" type="button" data-toggle="collapse" data-target=".navbar-buttons,.navbar-menu">
                        <span class="sr-only">Toggle user menu</span>

                        <img src="<?=$theme->getPath('images/avatars/avatar2.png');?>" alt="Jason's Photo" />
                    </button>

                    <button class="pull-right navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#sidebar">
                        <span class="sr-only">Toggle sidebar</span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>
                    </button>
                </div>
<?php 
if(!Yii::$app->user->isGuest){
?>
                <div class="navbar-buttons navbar-header pull-right  collapse navbar-collapse" role="navigation">
                    <ul class="nav ace-nav">
                          <li class="blue dropdown-modal">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                                <span class="badge badge-important">8</span>
                            </a>

                            <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-exclamation-triangle"></i>
                                    8 Notifications
                                </li>

                                <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                        New Comments
                                                    </span>
                                                    <span class="pull-right badge badge-info">+12</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="btn btn-xs btn-primary fa fa-user"></i>
                                                Bob just signed up as an editor ...
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                                        New Orders
                                                    </span>
                                                    <span class="pull-right badge badge-success">+8</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                        Followers
                                                    </span>
                                                    <span class="pull-right badge badge-info">+11</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See all notifications
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="light-blue dropdown-modal user-min">
                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                                <img class="nav-user-photo" src="<?=$theme->getPath('images/avatars/avatar2.png');?>"/>
                                <span class="user-info">
                                    <small>Welcome,</small>
                                   <?=Yii::$app->user->identity->username;?>
                                </span>

                                <i class="ace-icon fa fa-caret-down"></i>
                            </a>
                            <?php



echo Menu::widget([
    'options'=>['class'=>'user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close'],
    // 'itemOptions'=>array('class'=>'dropdown-menu'),
    // 'itemCssClass'=>'item-test',
    'encodeLabels'=>false,
    'items' => [
        ['label'=>'<i class="ace-icon fa fa-user"></i>Profil', 'url'=>['/pegawai/view','id'=>'']],
        ['label'=> '','itemOptions'=>['class'=>'divider']],
        ['label'=>'Pengguna', 'url'=>['/user/index']],
        ['label'=> '','itemOptions'=>['class'=>'divider']],
        ['label'=>'<li><a data-method="POST" href="'.\yii\helpers\Url::to(['/site/logout']).'">Logout</a></li>'],

    ],
]);

 ?>
                        
                        </li>
                    </ul>
                </div>
<?php 
}
?>
            </div><!-- /.navbar-container -->
        </div>

        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>

          <div id="sidebar" class="sidebar      h-sidebar                navbar-collapse collapse          ace-save-state">
                <script type="text/javascript">
                    try{ace.settings.loadState('sidebar')}catch(e){}
                </script>
               
                <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div><!-- /.sidebar-shortcuts -->

                  <?php 
    
    $menuItems = \app\helpers\MenuHelper::getMenuItems();              

       echo Menu::widget([
        'options'=>array('class'=>'nav nav-list'),
        'itemOptions'=>array('class'=>'hover'),
        // 'itemCssClass'=>'hover',
        'encodeLabels'=>false,
        'items' => $menuItems
    ]);

          
            ?>
            
            </div>
            <div class="main-content">
                <div class="main-content-inner">
                    <?php 
                    if(isset($this->params['breadcrumbs'])){
                    ?>
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <?php

                        echo Breadcrumbs::widget([
                            // 'options' => [
                            //     'class' => 'breadcrumb',
                            // ]
                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        ]);

                         ?>
                       

                        
                    </div>
                    <?php 
                }
                    ?>
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

            <div class="footer">
                <div class="footer-inner">
                    <div class="footer-content">
                        <span class="bigger-120">
                            <span class="blue bolder"><?=Yii::$app->params['shortname'];?></span>
                              2017-<?=date('Y');?>
                        </span>

                        &nbsp; &nbsp;
                        <span class="action-buttons">
                            <a href="#">
                                <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>
                            </a>

                            <a href="#">
                                <i class="ace-icon fa fa-rss-square orange bigger-150"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

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
    jQuery(function($) {
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
