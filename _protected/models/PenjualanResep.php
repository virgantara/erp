<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan_resep}}".
 *
 * @property int $id
 * @property int $penjualan_id
 * @property string $kode_daftar
 * @property int $pasien_id
 * @property string $pasien_nama
 * @property string $pasien_jenis
 * @property int $dokter_id
 * @property string $dokter_nama
 * @property int $unit_id
 * @property string $unit_nama
 * @property int $jenis_rawat 1=RJ, 2=RI
 * @property int $jenis_resep_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property JenisResep $jenisResep
 * @property Penjualan $penjualan
 */
class PenjualanResep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penjualan_resep}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_id', 'pasien_id', 'dokter_id', 'jenis_resep_id'], 'required'],
            [['penjualan_id', 'pasien_id', 'dokter_id', 'unit_id', 'jenis_rawat', 'jenis_resep_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_daftar'], 'string', 'max' => 20],
            [['pasien_nama', 'pasien_jenis', 'dokter_nama', 'unit_nama'], 'string', 'max' => 255],
            [['jenis_resep_id'], 'exist', 'skipOnError' => true, 'targetClass' => JenisResep::className(), 'targetAttribute' => ['jenis_resep_id' => 'id']],
            [['penjualan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'penjualan_id' => 'Penjualan ID',
            'kode_daftar' => 'Kode Daftar',
            'pasien_id' => 'Pasien ID',
            'pasien_nama' => 'Pasien Nama',
            'pasien_jenis' => 'Pasien Jenis',
            'dokter_id' => 'Dokter ID',
            'dokter_nama' => 'Dokter Nama',
            'unit_id' => 'Unit ID',
            'unit_nama' => 'Unit Nama',
            'jenis_rawat' => 'Jenis Rawat',
            'jenis_resep_id' => 'Jenis Resep ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenisResep()
    {
        return $this->hasOne(JenisResep::className(), ['id' => 'jenis_resep_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan()
    {
        return $this->hasOne(Penjualan::className(), ['id' => 'penjualan_id']);
    }

    public static function getCountResep($unit_id)
    {
      $count = PenjualanResep::find()
        ->where(['unit_id'=>$unit_id])
        ->count();
      
      return $count;  
    }
}
