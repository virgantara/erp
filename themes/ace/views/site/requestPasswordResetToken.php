<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Request password reset');
$this->params['breadcrumbs'][] = $this->title;
?>
 <div class="position-relative">
    <div id="login-box" class="login-box visible widget-box no-border">
      <div class="widget-body">
        <div class="widget-main">
          <h4 class="header blue lighter bigger">
            <i class="ace-icon fa fa-coffee green"></i>
            Please Enter Your Information
          </h4>

          <div class="space-6"></div>

      <p><?= Yii::t('app', 'A link to reset password will be sent to your email.') ?></p>

<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
<label class="block clearfix">
  <span class="block input-icon input-icon-right">
        <?= $form->field($model, 'email')->input('email', 
        ['placeholder' => Yii::t('app', 'Please fill out your email.'), 'autofocus' => true]) ?>
    
    <i class="ace-icon fa fa-user"></i>
  </span>
</label>
<div class="space"></div>

<div class="clearfix">

 <?= Html::submitButton(Yii::t('app', '<i class="ace-icon fa fa-key"></i>
    <span class="bigger-110">Send</span>'), ['class' => 'width-35 pull-right btn btn-sm btn-primary', 'name' => 'login-button']) ?>

</div>
  

 

<?php ActiveForm::end(); ?>

        </div><!-- /.widget-main -->
      
        
        </div>
  
      </div><!-- /.widget-body -->
    </div><!-- /.login-box -->



  </div><!-- /.position-relative -->
