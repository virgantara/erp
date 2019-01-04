<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tr_rawat_inap}}".
 *
 * @property int $id_rawat_inap
 * @property double $kode_rawat
 * @property string $tanggal_masuk
 * @property string $jam_masuk
 * @property string $tanggal_keluar
 * @property string $jam_keluar
 * @property string $datetime_masuk
 * @property string $datetime_keluar
 * @property string $created
 * @property int $pasien_id
 * @property int $jenis_pasien
 * @property int $kamar_id
 * @property int $dokter_id
 * @property double $biaya_paket_1
 * @property double $biaya_paket_2
 * @property double $biaya_paket_3
 * @property int $status_inap 1 =  masuk, 0 = keluar
 * @property int $status_rawat 0 = Inap, 1 = Jalan
 * @property string $datetime_masuk_ird
 * @property string $tanggal_masuk_ird
 * @property string $jam_masuk_ird
 * @property string $datetime_keluar_ird
 * @property string $tanggal_keluar_ird
 * @property string $jam_keluar_ird
 * @property string $tanggal_pulang
 * @property string $jam_pulang
 * @property string $datetime_pulang
 * @property int $prev_kamar
 * @property int $next_kamar
 * @property string $jenis_ird
 * @property int $status_pasien
 * @property int $is_naik_kelas
 * @property double $biaya_total_kamar
 * @property double $biaya_total_ird
 * @property double $biaya_dibayar
 * @property double $biaya_kamar
 * @property int $is_tarif_kamar_penuh
 * @property int $is_locked
 *
 * @property DmDokter $dokter
 * @property DmKamar $kamar
 * @property AGolpasien $jenisPasien
 * @property APasien $pasien
 * @property TrRawatInapAlkes[] $trRawatInapAlkes
 * @property TrRawatInapAlkesObat[] $trRawatInapAlkesObats
 * @property TrRawatInapKamarHistory[] $trRawatInapKamarHistories
 * @property TrRawatInapLain[] $trRawatInapLains
 * @property TrRawatInapLayanan[] $trRawatInapLayanans
 * @property TrRawatInapPenunjang[] $trRawatInapPenunjangs
 * @property TrRawatInapRincian[] $trRawatInapRincians
 * @property TrRawatInapTarifKamar[] $trRawatInapTarifKamars
 * @property TrRawatInapTnop[] $trRawatInapTnops
 * @property TrRawatInapTop[] $trRawatInapTops
 * @property TrRawatInapVisiteDokter[] $trRawatInapVisiteDokters
 */
class RawatInap extends SimrsModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tr_rawat_inap}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_rawat', 'biaya_paket_1', 'biaya_paket_2', 'biaya_paket_3', 'biaya_total_kamar', 'biaya_total_ird', 'biaya_dibayar', 'biaya_kamar'], 'number'],
            [['tanggal_masuk', 'jam_masuk', 'datetime_masuk', 'pasien_id', 'jenis_pasien', 'kamar_id'], 'required'],
            [['tanggal_masuk', 'jam_masuk', 'tanggal_keluar', 'jam_keluar', 'datetime_masuk', 'datetime_keluar', 'created', 'datetime_masuk_ird', 'tanggal_masuk_ird', 'jam_masuk_ird', 'datetime_keluar_ird', 'tanggal_keluar_ird', 'jam_keluar_ird', 'tanggal_pulang', 'jam_pulang', 'datetime_pulang'], 'safe'],
            [['pasien_id', 'jenis_pasien', 'kamar_id', 'dokter_id', 'status_inap', 'status_rawat', 'prev_kamar', 'next_kamar', 'status_pasien', 'is_naik_kelas', 'is_tarif_kamar_penuh', 'is_locked'], 'integer'],
            [['jenis_ird'], 'string', 'max' => 255],
            [['dokter_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmDokter::className(), 'targetAttribute' => ['dokter_id' => 'id_dokter']],
            [['kamar_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmKamar::className(), 'targetAttribute' => ['kamar_id' => 'id_kamar']],
            [['jenis_pasien'], 'exist', 'skipOnError' => true, 'targetClass' => AGolpasien::className(), 'targetAttribute' => ['jenis_pasien' => 'KodeGol']],
            [['pasien_id'], 'exist', 'skipOnError' => true, 'targetClass' => APasien::className(), 'targetAttribute' => ['pasien_id' => 'NoMedrec']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rawat_inap' => 'Id Rawat Inap',
            'kode_rawat' => 'Kode Rawat',
            'tanggal_masuk' => 'Tanggal Masuk',
            'jam_masuk' => 'Jam Masuk',
            'tanggal_keluar' => 'Tanggal Keluar',
            'jam_keluar' => 'Jam Keluar',
            'datetime_masuk' => 'Datetime Masuk',
            'datetime_keluar' => 'Datetime Keluar',
            'created' => 'Created',
            'pasien_id' => 'Pasien ID',
            'jenis_pasien' => 'Jenis Pasien',
            'kamar_id' => 'Kamar ID',
            'dokter_id' => 'Dokter ID',
            'biaya_paket_1' => 'Biaya Paket 1',
            'biaya_paket_2' => 'Biaya Paket 2',
            'biaya_paket_3' => 'Biaya Paket 3',
            'status_inap' => 'Status Inap',
            'status_rawat' => 'Status Rawat',
            'datetime_masuk_ird' => 'Datetime Masuk Ird',
            'tanggal_masuk_ird' => 'Tanggal Masuk Ird',
            'jam_masuk_ird' => 'Jam Masuk Ird',
            'datetime_keluar_ird' => 'Datetime Keluar Ird',
            'tanggal_keluar_ird' => 'Tanggal Keluar Ird',
            'jam_keluar_ird' => 'Jam Keluar Ird',
            'tanggal_pulang' => 'Tanggal Pulang',
            'jam_pulang' => 'Jam Pulang',
            'datetime_pulang' => 'Datetime Pulang',
            'prev_kamar' => 'Prev Kamar',
            'next_kamar' => 'Next Kamar',
            'jenis_ird' => 'Jenis Ird',
            'status_pasien' => 'Status Pasien',
            'is_naik_kelas' => 'Is Naik Kelas',
            'biaya_total_kamar' => 'Biaya Total Kamar',
            'biaya_total_ird' => 'Biaya Total Ird',
            'biaya_dibayar' => 'Biaya Dibayar',
            'biaya_kamar' => 'Biaya Kamar',
            'is_tarif_kamar_penuh' => 'Is Tarif Kamar Penuh',
            'is_locked' => 'Is Locked',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDokter()
    {
        return $this->hasOne(DmDokter::className(), ['id_dokter' => 'dokter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKamar()
    {
        return $this->hasOne(DmKamar::className(), ['id_kamar' => 'kamar_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisPasien()
    {
        return $this->hasOne(AGolpasien::className(), ['KodeGol' => 'jenis_pasien']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasien()
    {
        return $this->hasOne(APasien::className(), ['NoMedrec' => 'pasien_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapAlkes()
    {
        return $this->hasMany(TrRawatInapAlkes::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapAlkesObats()
    {
        return $this->hasMany(TrRawatInapAlkesObat::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapKamarHistories()
    {
        return $this->hasMany(TrRawatInapKamarHistory::className(), ['tr_ri_id' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapLains()
    {
        return $this->hasMany(TrRawatInapLain::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapLayanans()
    {
        return $this->hasMany(TrRawatInapLayanan::className(), ['id_ri' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapPenunjangs()
    {
        return $this->hasMany(TrRawatInapPenunjang::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapRincians()
    {
        return $this->hasMany(TrRawatInapRincian::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapTarifKamars()
    {
        return $this->hasMany(TrRawatInapTarifKamar::className(), ['id_ri' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapTnops()
    {
        return $this->hasMany(TrRawatInapTnop::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapTops()
    {
        return $this->hasMany(TrRawatInapTop::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapVisiteDokters()
    {
        return $this->hasMany(TrRawatInapVisiteDokter::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }
}
