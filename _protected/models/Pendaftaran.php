<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%b_pendaftaran}}".
 *
 * @property double $NODAFTAR
 * @property int $NoMedrec
 * @property int $KodePtgs
 * @property string $TGLDAFTAR
 * @property string $JamDaftar
 * @property int $umurthn
 * @property int $umurbln
 * @property int $UmurHr
 * @property int $KodeJnsUsia
 * @property int $KodeMasuk
 * @property string $KetMasuk
 * @property int $JnsRawat
 * @property string $DUtama
 * @property string $D1
 * @property string $D2
 * @property string $D3
 * @property string $D4
 * @property string $D5
 * @property string $P1
 * @property string $P2
 * @property string $P3
 * @property string $P4
 * @property string $P5
 * @property string $PxBaruLama 0 Px Lama, 1 Px Baru
 * @property double $IdAntri
 * @property int $KunjunganKe
 * @property string $KeluarRS
 * @property string $TglKRS
 * @property string $JamKRS
 * @property int $LamaRawat
 * @property int $KodeUnitDaftar
 * @property int $KunjTerakhirRJ
 * @property int $KodeGol
 * @property int $KodeStatusRM
 * @property int $IsRGT
 * @property string $NoSEP
 * @property int $KodeSubPulang
 * @property string $DPJP
 *
 * @property APasien $noMedrec
 * @property AGolpasien $kodeGol
 * @property ARefcarapulangdtl $kodeSubPulang
 * @property ARefcaramasuk $kodeMasuk
 * @property BPendaftaranRinap[] $bPendaftaranRinaps
 * @property BPendaftaranRjalan[] $bPendaftaranRjalans
 * @property TdRegisterOk[] $tdRegisterOks
 * @property TrResepPasien[] $trResepPasiens
 * @property TrTrackingRm[] $trTrackingRms
 */
class Pendaftaran extends SimrsModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_pendaftaran}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NoMedrec', 'KodePtgs', 'umurthn', 'umurbln', 'UmurHr', 'KodeJnsUsia', 'KodeMasuk', 'JnsRawat', 'KunjunganKe', 'LamaRawat', 'KodeUnitDaftar', 'KunjTerakhirRJ', 'KodeGol', 'KodeStatusRM', 'IsRGT', 'KodeSubPulang'], 'integer'],
            [['KodePtgs'], 'required'],
            [['TGLDAFTAR', 'JamDaftar', 'TglKRS', 'JamKRS'], 'safe'],
            [['IdAntri'], 'number'],
            [['KetMasuk'], 'string', 'max' => 60],
            [['DUtama', 'D1', 'D2', 'D3', 'D4', 'D5', 'P1', 'P2', 'P3', 'P4', 'P5'], 'string', 'max' => 10],
            [['PxBaruLama'], 'string', 'max' => 4],
            [['KeluarRS'], 'string', 'max' => 1],
            [['NoSEP'], 'string', 'max' => 20],
            [['DPJP'], 'string', 'max' => 30],
            [['NoMedrec'], 'exist', 'skipOnError' => true, 'targetClass' => Pasien::className(), 'targetAttribute' => ['NoMedrec' => 'NoMedrec']],
            [['KodeGol'], 'exist', 'skipOnError' => true, 'targetClass' => Golpasien::className(), 'targetAttribute' => ['KodeGol' => 'KodeGol']],
            [['KodeSubPulang'], 'exist', 'skipOnError' => true, 'targetClass' => Refcarapulangdtl::className(), 'targetAttribute' => ['KodeSubPulang' => 'KodeSub']],
            [['KodeMasuk'], 'exist', 'skipOnError' => true, 'targetClass' => Refcaramasuk::className(), 'targetAttribute' => ['KodeMasuk' => 'KodeMasuk']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NODAFTAR' => 'Nodaftar',
            'NoMedrec' => 'No Medrec',
            'KodePtgs' => 'Kode Ptgs',
            'TGLDAFTAR' => 'Tgldaftar',
            'JamDaftar' => 'Jam Daftar',
            'umurthn' => 'Umurthn',
            'umurbln' => 'Umurbln',
            'UmurHr' => 'Umur Hr',
            'KodeJnsUsia' => 'Kode Jns Usia',
            'KodeMasuk' => 'Kode Masuk',
            'KetMasuk' => 'Ket Masuk',
            'JnsRawat' => 'Jns Rawat',
            'DUtama' => 'Dutama',
            'D1' => 'D1',
            'D2' => 'D2',
            'D3' => 'D3',
            'D4' => 'D4',
            'D5' => 'D5',
            'P1' => 'P1',
            'P2' => 'P2',
            'P3' => 'P3',
            'P4' => 'P4',
            'P5' => 'P5',
            'PxBaruLama' => 'Px Baru Lama',
            'IdAntri' => 'Id Antri',
            'KunjunganKe' => 'Kunjungan Ke',
            'KeluarRS' => 'Keluar Rs',
            'TglKRS' => 'Tgl Krs',
            'JamKRS' => 'Jam Krs',
            'LamaRawat' => 'Lama Rawat',
            'KodeUnitDaftar' => 'Kode Unit Daftar',
            'KunjTerakhirRJ' => 'Kunj Terakhir Rj',
            'KodeGol' => 'Kode Gol',
            'KodeStatusRM' => 'Kode Status Rm',
            'IsRGT' => 'Is Rgt',
            'NoSEP' => 'No Sep',
            'KodeSubPulang' => 'Kode Sub Pulang',
            'DPJP' => 'Dpjp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPasien()
    {
        return $this->hasOne(Pasien::className(), ['NoMedrec' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeGol()
    {
        return $this->hasOne(Golpasien::className(), ['KodeGol' => 'KodeGol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeSubPulang()
    {
        return $this->hasOne(Refcarapulangdtl::className(), ['KodeSub' => 'KodeSubPulang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKodeMasuk()
    {
        return $this->hasOne(Refcaramasuk::className(), ['KodeMasuk' => 'KodeMasuk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftaranRinaps()
    {
        return $this->hasMany(BPendaftaranRinap::className(), ['NoDaftar' => 'NODAFTAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftaranRjalans()
    {
        return $this->hasMany(BPendaftaranRjalan::className(), ['NoDaftar' => 'NODAFTAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getTdRegisterOks()
    // {
    //     return $this->hasMany(TdRegisterOk::className(), ['kode_daftar' => 'NODAFTAR']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrResepPasiens()
    {
        return $this->hasMany(TrResepPasien::className(), ['nodaftar_id' => 'NODAFTAR']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrTrackingRms()
    {
        return $this->hasMany(TrTrackingRm::className(), ['b_pendaftaran_id' => 'NODAFTAR']);
    }
}
