<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gol_pasien".
 *
 * @property int $KodeGol
 * @property string $NamaGol
 * @property int $a_kpid
 * @property string $Inisial
 * @property int $KodeKlsHak
 * @property int $JenisKlsHak
 * @property int $KodeAturan
 * @property string $NoAwal
 * @property int $IsPBI
 * @property int $MblAmbGratis
 * @property int $MblJnhGratis
 * @property int $KDJNSKPST
 * @property int $KDJNSPESERTA
 * @property int $IsKaryawan
 *
 * @property TrRawatInap[] $trRawatInaps
 */
class GolPasien extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gol_pasien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['a_kpid', 'KodeKlsHak', 'JenisKlsHak', 'KodeAturan', 'IsPBI', 'MblAmbGratis', 'MblJnhGratis', 'KDJNSKPST', 'KDJNSPESERTA', 'IsKaryawan'], 'integer'],
            [['Inisial', 'NoAwal'], 'required'],
            [['NamaGol'], 'string', 'max' => 80],
            [['Inisial'], 'string', 'max' => 2],
            [['NoAwal'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodeGol' => 'Kode Gol',
            'NamaGol' => 'Nama Gol',
            'a_kpid' => 'A Kpid',
            'Inisial' => 'Inisial',
            'KodeKlsHak' => 'Kode Kls Hak',
            'JenisKlsHak' => 'Jenis Kls Hak',
            'KodeAturan' => 'Kode Aturan',
            'NoAwal' => 'No Awal',
            'IsPBI' => 'Is Pbi',
            'MblAmbGratis' => 'Mbl Amb Gratis',
            'MblJnhGratis' => 'Mbl Jnh Gratis',
            'KDJNSKPST' => 'Kdjnskpst',
            'KDJNSPESERTA' => 'Kdjnspeserta',
            'IsKaryawan' => 'Is Karyawan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInaps()
    {
        return $this->hasMany(TrRawatInap::className(), ['jenis_pasien' => 'KodeGol']);
    }
}
