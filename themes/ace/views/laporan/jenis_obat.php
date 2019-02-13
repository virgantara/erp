<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BarangOpname */
/* @var $form yii\widgets\ActiveForm */


$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d');
$this->title = 'Laporan Jenis Barang';

$this->params['breadcrumbs'][] = $this->title;
$listDepartment = \app\models\Departemen::getListDepartemens();

?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="barang-opname-form">

     <?php $form = ActiveForm::begin([
        'action' => ['laporan/jenis-barang'],
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
       


        </div>
    </div>
    

        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> </label>
            <div class="col-sm-2">
 <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Cari', ['class' => 'btn btn-info','name'=>'search','value'=>1]) ?>    
 <?= Html::submitButton(' <i class="ace-icon fa fa-check bigger-110"></i>Export XLS', ['class' => 'btn btn-success','name'=>'export','value'=>1]) ?>   
            </div>
  
        </div>
      <?php ActiveForm::end(); ?>
       <?php 
   echo $this->render('_tabel_jenis_barang', [
             'list' => $list,
             'results' => $results,
            'model' => $model,
        ]); 
    ?>
  

  
</div>
