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
<body class="login-layout light-login">
     <div class="main-container">
      <div class="main-content">
        <div class="row">
          <div class="col-sm-10 col-sm-offset-1">
            <div class="login-container">
              <div class="center">
                <h1>
                  <i class="ace-icon fa fa-leaf green"></i>
                  <span class="red"><?=Yii::$app->name;?></span>
                  <span class="white" id="id-text2"></span>
                </h1>
                <h4 class="blue" id="id-company-text"><?=Yii::$app->params['owner'];?></h4>
              </div>

              <div class="space-6"></div>
              <?=$content;?>
             

           
            </div>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.main-content -->
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

</body>

</html>
<?php $this->endPage() ?>
