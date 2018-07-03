<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInapAlkesObat */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tr Rawat Inap Alkes Obats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-rawat-inap-alkes-obat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'id_rawat_inap',
            'kode_alkes',
            'keterangan',
            'nilai',
            'created',
            'id_m_obat_akhp',
            'tanggal_input',
            'id_dokter',
            'jumlah',
        ],
    ]) ?>

</div>
