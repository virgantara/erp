<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_master_barang".
 *
 * @property int $id_barang
 * @property string $nama_barang
 * @property double $harga_beli
 * @property double $harga_jual
 * @property int $id_satuan
 * @property string $created
 * @property int $id_perusahaan
 * @property int $id_gudang
 *
 * @property SalesFakturBarang[] $salesFakturBarangs
 * @property Perusahaan $perusahaan
 * @property SalesMasterGudang $gudang
 * @property SalesSatuan $satuan
 * @property SalesStokGudang[] $salesStokGudangs
 */
class SalesBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_master_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_barang', 'harga_beli', 'harga_jual', 'id_satuan', 'id_perusahaan', 'id_gudang','jumlah'], 'required'],
            [['harga_beli', 'harga_jual','jumlah'], 'number'],
            [['id_satuan', 'id_perusahaan', 'id_gudang'], 'integer'],
            [['created'], 'safe'],
            [['nama_barang'], 'string', 'max' => 255],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
            [['id_gudang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['id_gudang' => 'id_gudang']],
            [['id_satuan'], 'exist', 'skipOnError' => true, 'targetClass' => SatuanBarang::className(), 'targetAttribute' => ['id_satuan' => 'id_satuan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_barang' => 'Id Barang',
            'nama_barang' => 'Nama Barang',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'id_satuan' => 'Satuan',
            'created' => 'Created',
            'id_perusahaan' => 'Perusahaan',
            'id_gudang' => 'Gudang',
            'jumlah'    => 'Jumlah'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFakturBarang::className(), ['id_barang' => 'id_barang']);
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
    public function getGudang()
    {
        return $this->hasOne(SalesMasterGudang::className(), ['id_gudang' => 'id_gudang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(SatuanBarang::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getNamaSatuan()
    {
        return $this->satuan->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesStokGudangs()
    {
        return $this->hasMany(SalesStokGudang::className(), ['id_barang' => 'id_barang']);
    }
}
