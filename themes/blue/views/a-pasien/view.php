<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\APasien */

$this->title = $model->NoMedrec;
$this->params['breadcrumbs'][] = ['label' => 'Apasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apasien-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NoMedrec], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NoMedrec], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'NoMedrec',
            'NAMA',
            'ALAMAT',
            'KodeKec',
            'TMPLAHIR',
            'TGLLAHIR',
            'PEKERJAAN',
            'AGAMA',
            'JENSKEL',
            'GOLDARAH',
            'TELP',
            'JENISIDENTITAS',
            'NOIDENTITAS',
            'STATUSPERKAWINAN',
            'BeratLahir',
            'Desa',
            'KodeGol',
            'TglInput',
            'JamInput',
            'AlmIp',
            'NoMedrecLama',
            'NoKpst',
            'KodePisa',
            'KdPPK',
            'NamaOrtu',
            'NamaSuamiIstri',
        ],
    ]) ?>

</div>
