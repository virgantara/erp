<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Kas;
use \kartik\grid\GridView;

use app\models\Saldo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\KasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kas Besar | '.Yii::$app->params['shortname'];
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

    ?>

    <div class="col-xs-4 col-md-3 col-lg-2">
        
        <?= Html::dropDownList('bulan', !empty($_POST['bulan']) ? $_POST['bulan'] : date('m'),$bulans,['class'=>'form-control ']); ?>

    </div>
     <div class="col-xs-4 col-md-3 col-lg-2">
        
       
        <?= Html::dropDownList('tahun', !empty($_POST['tahun']) ? $_POST['tahun'] : date('Y'),$tahuns,['class'=>'form-control ']); ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
    <?php 
    ActiveForm::end();

    $saldo_awal = 0;
    $session = Yii::$app->session;
    if($session->isActive)
    {
        $saldo_id = $session->get('saldo_id');

        $saldo = Saldo::find()->where(['id' => $saldo_id])->one();

        if(!empty($saldo))
        {
            $saldo_awal = $saldo->nilai_awal;
            
        }
    }
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'showFooter' => true,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            
            'kwitansi',
             [
             'attribute' =>'penanggung_jawab',
             'footer' => '<strong>Total</strong>',
            ],

            'keterangan:ntext',
            'tanggal',
            //'jenis_kas',
            

            [
             'attribute' =>'kas_keluar',
             'footer' => Kas::getTotal($dataProvider->models, 'kas_keluar'),

            ],
            [
             'attribute' =>'kas_masuk',
             'footer' => Kas::getTotal($dataProvider->models, 'kas_masuk'),
            ],
             [
             'label' =>'Saldo',
                'value' => function ($data, $key, $index, $column) {
                    return Kas::calcSaldo($data, 'kas_masuk');
                },
            ],
            //'created',

            ['class' => 'yii\grid\ActionColumn','visible'=>Yii::$app->user->can('admin')],
        ],
    ]); ?>
</div>
