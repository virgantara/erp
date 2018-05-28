<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_master_gudang".
 *
 * @property int $id_gudang
 * @property string $nama
 * @property string $alamat
 * @property string $telp
 * @property int $id_perusahaan
 *
 * @property SalesMasterBarang[] $salesMasterBarangs
 * @property Perusahaan $perusahaan
 * @property SalesStokGudang[] $salesStokGudangs
 */
class SalesMasterGudang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_master_gudang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'telp'], 'required'],
            [['id_perusahaan'], 'integer'],
            [['nama', 'alamat', 'telp'], 'string', 'max' => 255],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_gudang' => 'Id Gudang',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'id_perusahaan' => 'Id Perusahaan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesMasterBarangs()
    {
        return $this->hasMany(SalesMasterBarang::className(), ['id_gudang' => 'id_gudang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesStokGudangs()
    {
        return $this->hasMany(SalesStokGudang::className(), ['id_gudang' => 'id_gudang']);
    }
}
