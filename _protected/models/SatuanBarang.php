<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "satuan_barang".
 *
 * @property int $id_satuan
 * @property string $kode
 * @property string $nama
 * @property int $jenis
 *
 * @property SalesFakturBarang[] $salesFakturBarangs
 * @property SalesMasterBarang[] $salesMasterBarangs
 * @property PerusahaanJenis $jenis0
 */
class SatuanBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'satuan_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['jenis'], 'integer'],
            [['kode'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 50],
            [['jenis'], 'exist', 'skipOnError' => true, 'targetClass' => PerusahaanJenis::className(), 'targetAttribute' => ['jenis' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_satuan' => 'Id Satuan',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'jenis' => 'Jenis',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFakturBarang::className(), ['id_satuan' => 'id_satuan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesMasterBarangs()
    {
        return $this->hasMany(SalesMasterBarang::className(), ['id_satuan' => 'id_satuan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis0()
    {
        return $this->hasOne(PerusahaanJenis::className(), ['id' => 'jenis']);
    }

    public function getJenisPerusahaan()
    {
        return $this->jenis0->nama;
    }
}
