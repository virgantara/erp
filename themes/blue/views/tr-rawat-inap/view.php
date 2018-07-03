<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TrRawatInap */

$this->title = $model->id_rawat_inap;
$this->params['breadcrumbs'][] = ['label' => 'Tr Rawat Inaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tr-rawat-inap-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_rawat_inap], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_rawat_inap], [
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
            'id_rawat_inap',
            'kode_rawat',
            'tanggal_masuk',
            'jam_masuk',
            'tanggal_keluar',
            'jam_keluar',
            'datetime_masuk',
            'datetime_keluar',
            'created',
            'pasien_id',
            'jenis_pasien',
            'kamar_id',
            'dokter_id',
            'biaya_paket_1',
            'biaya_paket_2',
            'biaya_paket_3',
            'status_inap',
            'status_rawat',
            'datetime_masuk_ird',
            'tanggal_masuk_ird',
            'jam_masuk_ird',
            'datetime_keluar_ird',
            'tanggal_keluar_ird',
            'jam_keluar_ird',
            'tanggal_pulang',
            'jam_pulang',
            'datetime_pulang',
            'prev_kamar',
            'next_kamar',
            'jenis_ird',
            'status_pasien',
            'is_naik_kelas',
            'biaya_total_kamar',
            'biaya_total_ird',
            'biaya_dibayar',
            'biaya_kamar',
        ],
    ]) ?>

</div>
