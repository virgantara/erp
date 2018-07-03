<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

use yii\grid\GridView;

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInapAlkesObat */
/* @var $form yii\widgets\ActiveForm */

?>
 <?= DetailView::widget([
        'model' => $rawatInap,
        'attributes' => [
            'noRM',
            'namaPasien',
            [
                'label' => 'Kamar',
                'value' => function($model){
                    return $model->kamar->nama_kamar.' | '.$model->kamar->kelas->nama_kelas;
                }
            ],
            [
                'attribute' => 'datetime_masuk',
                'format' => 'datetime' 
            ],
            [
                'attribute' => 'datetime_keluar',
                'format' => 'datetime' 
            ],
             'lamaDirawat',
            
            'namaDokter',
        ],
    ]) ?>
<h1>Input Obat</h1>
<div class="tr-rawat-inap-alkes-obat-form">

    <?php 

    $action = [];

    if($model->isNewRecord){
        $action = ['tr-rawat-inap-alkes-obat/create','id'=>$rawatInap->id_rawat_inap];
    }

    else{
        $action = ['tr-rawat-inap-alkes-obat/update','id'=>$model->id];
    }
    $form = ActiveForm::begin(
        ['action'=>$action]
    ); ?>


    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai')->textInput() ?>
    <?= $form->field($model, 'tanggal_input')->widget(
        DatePicker::className(),[
            'options' => ['placeholder' => 'Select issue date ...'],
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]
    ) ?>
    
    <?php 
   
    echo '<label class="control-label">Nama Dokter</label>';
    $template = '<div><p class="repo-language">{{value}}</p>' .
    '<p class="repo-name">{{jenis}}</p>';
echo Typeahead::widget([
    'name' => 'nama_dokter',
    'value' => $model->isNewRecord ? '' : $model->namaDokter,
    'options' => ['placeholder' => 'Ketik nama dokter ...'],
    'pluginOptions' => ['highlight'=>true],
    'pluginEvents' => [
        "typeahead:select" => "function(event,ui) { 
            $('#trrawatinapalkesobat-id_dokter').val(ui.id);
            
        }",
    ],
    
    'dataset' => [
        [
            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            'display' => 'value',
            // 'prefetch' => $baseUrl . '/samples/countries.json',
            'remote' => [
                'url' => Url::to(['dm-dokter/ajax-dokter']) . '?q=%QUERY',
                'wildcard' => '%QUERY'
            ],
            'templates' => [
                'notFound' => '<div class="text-danger" style="padding:0 8px">Data dokter tidak ditemukan.</div>',
                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
            ]
        ]
    ]
]);
     echo $form->field($model, 'id_dokter')->hiddenInput()->label(false);
    ?>

    <?= $form->field($model, 'jumlah')->textInput() ?>

    <div class="form-group col-xs-12 col-lg-12">
        <?= Html::submitButton('SIMPAN', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


<h1>Data Obat</h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'keterangan',
            'nilai',
            //'created',
            //'id_m_obat_akhp',
            'tanggal_input',
            'namaDokter',
            'jumlah',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
