<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kas */
$jenisNama = ($jenis == 1) ? 'Masuk' : 'Keluar';
$this->title = 'Create Kas '.$jenisNama;
$this->params['breadcrumbs'][] = ['label' => 'Kas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
    switch ($jenis) {
    	case 1:
    		echo $this->render('_masuk', [
                'uk' => $uk,
		        'model' => $model,
		    ]);
    		break;
    	
    	case 0:
    		echo $this->render('_keluar', [
                'uk' => $uk,
		        'model' => $model,
		    ]);
    		break;
    }
     

    ?>

</div>
