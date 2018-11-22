<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Login');
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

         <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
<label class="block clearfix">
  <span class="block input-icon input-icon-right">
   <?php if ($model->scenario === 'lwe'): ?>

            <?= $form->field($model, 'email')->input('email', 
                ['placeholder' => Yii::t('app', 'Enter your e-mail'), 'autofocus' => true]) ?>

        <?php else: ?>

            <?= $form->field($model, 'username')->textInput(
                ['placeholder' => Yii::t('app', 'Enter your username'), 'autofocus' => true]) ?>

        <?php endif ?>

    <i class="ace-icon fa fa-user"></i>
  </span>
</label>
<label class="block clearfix">
  <span class="block input-icon input-icon-right">
      <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('app', 'Enter your password')]) ?>
    
    <i class="ace-icon fa fa-user"></i>
  </span>
</label>

<div class="space"></div>

<div class="clearfix">

 <?= Html::submitButton(Yii::t('app', '<i class="ace-icon fa fa-key"></i>
    <span class="bigger-110">Login</span>'), ['class' => 'width-35 pull-right btn btn-sm btn-primary', 'name' => 'login-button']) ?>

</div>


        <?php ActiveForm::end(); ?>

        </div><!-- /.widget-main -->
              <div class="toolbar clearfix">
          <div>
            <?php
            echo Html::a(Yii::t('app', '<i class="ace-icon fa fa-arrow-left"></i> I forgot my password'), ['site/request-password-reset'],['class'=>'forgot-password-link','data-target'=>'#forgot-box']) 
            ?>
        
          </div>

        
        </div>
  
      </div><!-- /.widget-body -->
    </div><!-- /.login-box -->



  </div><!-- /.position-relative -->


      
   