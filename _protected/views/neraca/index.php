<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Perkiraan;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NeracaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Neraca';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="neraca-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
 <div class="row">
     <div class="col-xs-6">
        <h4>AKTIVA</h4>    
       
            <h5>Aktiva Lancar</h5>
            <?php 
            
            foreach($aktivaLancar->perkiraans as $akun)
            {
                    
            ?>
            <div class="col-xs-6">
                <?=$akun->nama;?>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
            <?php 
            }
            ?>
            <div class="col-xs-6">
               <strong> Jumlah Aktiva Lancar</strong>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
       </div>
       <div class="col-xs-6"> 
        <h4>KEWAJIBAN DAN MODAL</h4>    
          

            <h5>Kewajiban Lancar</h5>
            <?php 
            
            foreach($kewajibanLancar->perkiraans as $akun)
            {
                    
            ?>
            <div class="col-xs-6">
                <?=$akun->nama;?>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
            <?php 
            }
            ?>
            <div class="col-xs-6">
                <strong>Jumlah Kewajiban Lancar</strong>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
        </div>
    </div>

 <div class="row">
    <div class="col-xs-6">

        <h5>Aktiva Tetap</h5>
            <?php 
            
            foreach($aktivaTetap->perkiraans as $akun)
            {
                    
            ?>
            <div class="col-xs-6">
                <?=$akun->nama;?>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
            <?php 
            }
            ?>
             <div class="col-xs-6">
                <strong>Jumlah Aktiva Tetap</strong>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
        </div>
        <div class="col-xs-6">
            
            <h5>Modal</h5>
            <?php 
            
            foreach($modal->perkiraans as $akun)
            {
                    
            ?>
            <div class="col-xs-6">
                <?=$akun->nama;?>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
            <?php 
            }
            ?>
            <div class="col-xs-6">
              <strong>  Jumlah Modal</strong>
            </div>
            <div class="col-xs-6" style="text-align: right">
                0
            </div>
        </div>
    </div>
</div>
