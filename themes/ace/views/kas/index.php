<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Kas;
use \kartik\grid\GridView;

use app\models\Saldo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kas '.ucwords($uk).' | '.Yii::$app->params['shortname'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 

$form = ActiveForm::begin();
    $bulans = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    ];

    $tahuns = [];

    for($i = 2016 ;$i<=date('Y')+50;$i++)
        $tahuns[$i] = $i;

    $bulan = !empty($_POST['bulan']) ? $_POST['bulan'] : date('m');
    $tahun = !empty($_POST['tahun']) ? $_POST['tahun'] : date('Y');

    ?>

    <div class="col-xs-4 col-md-3 col-lg-2">
        
        <?= Html::dropDownList('bulan', $bulan,$bulans,['class'=>'form-control ']); ?>

    </div>
     <div class="col-xs-4 col-md-3 col-lg-2">
        
       
        <?= Html::dropDownList('tahun', $tahun,$tahuns,['class'=>'form-control ']); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php 
    ActiveForm::end();

    $saldo_awal = 0;
    
    $session = Yii::$app->session;
    $userPt = '';
        
    $where = ['jenis' => $uk,'bulan'=>$bulan,'tahun'=>$tahun];
    if($session->isActive)
    {
        $userLevel = $session->get('level');    
        
        if($userLevel == 'admin'){
            $userPt = $session->get('perusahaan');
            array_merge($where,[
                'perusahaan_id' => $userPt
            ]);

           
        }
    }


    $saldo = Saldo::find()->where($where)->one();

    if(!empty($saldo))
    {
        $saldo_awal = $saldo->nilai_awal;
        
    }
    
    ?>

    <div class="grid-view hide-resize">
<div id="w1-container" class="table-responsive kv-grid-container">
    <table class="kv-grid-table table ">
        <thead>
<tr>        <th width="25%">&nbsp;</th>
            <th width="25%">&nbsp;</th>
            <th style="text-align: right;" width="20%"><h4>Saldo Awal</h4></th>
            <th style="text-align: right;"><h4><?=number_format($saldo_awal,2,',','.');?></h4></th>
        </tr>


</thead>
</table></div></div>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'showFooter' => true,
        'footerRowOptions'=>['style'=>'text-align:right;'],
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            
            // 'kwitansi',

            [
                'attribute'=> 'keterangan',
                'footer' => '<strong>Total</strong>',
            ],
            [
                'attribute' =>'tanggal',
                'format'=>'Date',
            ],
            [
             'attribute' =>'kas_keluar',
             'footer' => Kas::getTotal($dataProvider->models, 'kas_keluar'),
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],

            ],

            [
             'attribute' =>'kas_masuk',
             'footer' => Kas::getTotal($dataProvider->models, 'kas_masuk'),
             'format'=>'Currency',
             'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' =>'saldo',
                'format'=>'Currency',
                'contentOptions' => ['class' => 'text-right'],
            ],
            //'created',

            [
                'class' => 'yii\grid\ActionColumn',
                'visible'=>Yii::$app->user->can('admin'),
                'template' => '{view} {update} {delete}',
                'buttons' => [
                     'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                   'title'        => 'delete',
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method'  => 'post',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    
                    if ($action === 'delete') {
                        $url =Url::to(['kas/delete','id'=>$model->id,'uk'=>Yii::$app->getRequest()->getQueryParam('uk')]);
                        return $url;
                    }

                  }
            ],
        ],
    ]); ?>
</div>
