<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%a_pasien}}".
 *
 * @property int $NoMedrec
 * @property string $NAMA
 * @property string $ALAMAT
 * @property int $KodeKec
 * @property string $TMPLAHIR
 * @property string $TGLLAHIR
 * @property string $PEKERJAAN
 * @property string $AGAMA
 * @property string $JENSKEL
 * @property string $GOLDARAH
 * @property string $TELP
 * @property string $JENISIDENTITAS
 * @property string $NOIDENTITAS
 * @property string $STATUSPERKAWINAN
 * @property int $BeratLahir
 * @property string $Desa
 * @property int $KodeGol
 * @property string $TglInput
 * @property string $JamInput
 * @property string $AlmIp
 * @property int $NoMedrecLama
 * @property string $NoKpst
 * @property int $KodePisa
 * @property string $KdPPK
 * @property string $NamaOrtu
 * @property string $NamaSuamiIstri
 *
 * @property APasienAlamat[] $aPasienAlamats
 * @property BPendaftaran[] $bPendaftarans
 * @property BPendaftaranri[] $bPendaftaranris
 * @property BpjsPasien[] $bpjsPasiens
 * @property BpjsSep[] $bpjsSeps
 * @property TdRegisterOk[] $tdRegisterOks
 * @property TdRegisterOk[] $tdRegisterOks0
 * @property TrPendaftaranRjalan[] $trPendaftaranRjalans
 * @property TrRawatInap[] $trRawatInaps
 * @property TrResepPasien[] $trResepPasiens
 */
class Pasien extends SimrsModel
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%a_pasien}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KodeKec', 'BeratLahir', 'KodeGol', 'NoMedrecLama', 'KodePisa'], 'integer'],
            [['TGLLAHIR', 'TglInput', 'JamInput'], 'safe'],
            [['NAMA', 'PEKERJAAN', 'STATUSPERKAWINAN', 'NoKpst', 'NamaOrtu', 'NamaSuamiIstri'], 'string', 'max' => 30],
            [['ALAMAT'], 'string', 'max' => 80],
            [['TMPLAHIR'], 'string', 'max' => 15],
            [['AGAMA', 'JENISIDENTITAS', 'NOIDENTITAS'], 'string', 'max' => 25],
            [['JENSKEL'], 'string', 'max' => 1],
            [['GOLDARAH'], 'string', 'max' => 10],
            [['TELP', 'Desa'], 'string', 'max' => 40],
            [['AlmIp'], 'string', 'max' => 20],
            [['KdPPK'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NoMedrec' => 'No Medrec',
            'NAMA' => 'Nama',
            'ALAMAT' => 'Alamat',
            'KodeKec' => 'Kode Kec',
            'TMPLAHIR' => 'Tmplahir',
            'TGLLAHIR' => 'Tgllahir',
            'PEKERJAAN' => 'Pekerjaan',
            'AGAMA' => 'Agama',
            'JENSKEL' => 'Jenskel',
            'GOLDARAH' => 'Goldarah',
            'TELP' => 'Telp',
            'JENISIDENTITAS' => 'Jenisidentitas',
            'NOIDENTITAS' => 'Noidentitas',
            'STATUSPERKAWINAN' => 'Statusperkawinan',
            'BeratLahir' => 'Berat Lahir',
            'Desa' => 'Desa',
            'KodeGol' => 'Kode Gol',
            'TglInput' => 'Tgl Input',
            'JamInput' => 'Jam Input',
            'AlmIp' => 'Alm Ip',
            'NoMedrecLama' => 'No Medrec Lama',
            'NoKpst' => 'No Kpst',
            'KodePisa' => 'Kode Pisa',
            'KdPPK' => 'Kd Ppk',
            'NamaOrtu' => 'Nama Ortu',
            'NamaSuamiIstri' => 'Nama Suami Istri',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAPasienAlamats()
    {
        return $this->hasMany(APasienAlamat::className(), ['pasien_id' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftarans()
    {
        return $this->hasMany(BPendaftaran::className(), ['NoMedrec' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftaranris()
    {
        return $this->hasMany(BPendaftaranri::className(), ['NoMedrec' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBpjsPasiens()
    {
        return $this->hasMany(BpjsPasien::className(), ['PASIEN_ID' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBpjsSeps()
    {
        return $this->hasMany(BpjsSep::className(), ['NO_RM' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTdRegisterOks()
    {
        return $this->hasMany(TdRegisterOk::className(), ['no_rm' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTdRegisterOks0()
    {
        return $this->hasMany(TdRegisterOk::className(), ['no_rm' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrPendaftaranRjalans()
    {
        return $this->hasMany(TrPendaftaranRjalan::className(), ['NoMedrec' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInaps()
    {
        return $this->hasMany(TrRawatInap::className(), ['pasien_id' => 'NoMedrec']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrResepPasiens()
    {
        return $this->hasMany(TrResepPasien::className(), ['pasien_id' => 'NoMedrec']);
    }
}
