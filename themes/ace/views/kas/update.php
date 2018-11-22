<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kas */
$jenisNama = ($jenis == 1) ? 'Masuk' : 'Keluar';
$this->title = 'Update Kas: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    switch ($jenis) {
    	case 1:
    		echo $this->render('_masuk', [
		        'model' => $model,
		    ]);
    		break;
    	
    	case 0:
    		echo $this->render('_keluar', [
		        'model' => $model,
		    ]);
    		break;
    }
     

    ?>

</div>
