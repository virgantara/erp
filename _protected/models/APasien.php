<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "a_pasien".
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
 */
class APasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'a_pasien';
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
}
