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
 * @property int $dokter_id
 * @property int $jenis_rawat 1=RJ, 2=RI
 * @property string $created_at
 * @property string $updated_at
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
            [['penjualan_id', 'pasien_id', 'dokter_id'], 'required'],
            [['penjualan_id', 'pasien_id', 'dokter_id', 'jenis_rawat'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_daftar'], 'string', 'max' => 20],
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
            'dokter_id' => 'Dokter ID',
            'jenis_rawat' => 'Jenis Rawat',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
