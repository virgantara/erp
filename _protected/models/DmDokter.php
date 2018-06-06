<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_dokter".
 *
 * @property int $id_dokter
 * @property string $nama_dokter
 * @property string $jenis_dokter
 * @property double $prosentasi_jasa
 * @property string $alamat_praktik
 * @property string $telp
 * @property string $created
 * @property string $nama_panggilan
 *
 * @property TrRawatInap[] $trRawatInaps
 * @property TrRawatInapAlkesObat[] $trRawatInapAlkesObats
 */
class DmDokter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_dokter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_dokter', 'jenis_dokter', 'prosentasi_jasa', 'alamat_praktik', 'telp', 'nama_panggilan'], 'required'],
            [['prosentasi_jasa'], 'number'],
            [['created'], 'safe'],
            [['nama_dokter', 'jenis_dokter', 'alamat_praktik'], 'string', 'max' => 255],
            [['telp', 'nama_panggilan'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_dokter' => 'Id Dokter',
            'nama_dokter' => 'Nama Dokter',
            'jenis_dokter' => 'Jenis Dokter',
            'prosentasi_jasa' => 'Prosentasi Jasa',
            'alamat_praktik' => 'Alamat Praktik',
            'telp' => 'Telp',
            'created' => 'Created',
            'nama_panggilan' => 'Nama Panggilan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInaps()
    {
        return $this->hasMany(TrRawatInap::className(), ['dokter_id' => 'id_dokter']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapAlkesObats()
    {
        return $this->hasMany(TrRawatInapAlkesObat::className(), ['id_dokter' => 'id_dokter']);
    }
}
