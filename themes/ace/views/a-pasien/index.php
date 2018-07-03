<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\APasienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apasiens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apasien-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apasien', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NoMedrec',
            'NAMA',
            'ALAMAT',
            'KodeKec',
            'TMPLAHIR',
            //'TGLLAHIR',
            //'PEKERJAAN',
            //'AGAMA',
            //'JENSKEL',
            //'GOLDARAH',
            //'TELP',
            //'JENISIDENTITAS',
            //'NOIDENTITAS',
            //'STATUSPERKAWINAN',
            //'BeratLahir',
            //'Desa',
            //'KodeGol',
            //'TglInput',
            //'JamInput',
            //'AlmIp',
            //'NoMedrecLama',
            //'NoKpst',
            //'KodePisa',
            //'KdPPK',
            //'NamaOrtu',
            //'NamaSuamiIstri',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
