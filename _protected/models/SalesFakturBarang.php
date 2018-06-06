<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_faktur_barang".
 *
 * @property int $id_faktur_barang
 * @property int $id_faktur
 * @property int $id_barang
 * @property int $jumlah
 * @property int $id_satuan
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 * @property SalesFaktur $faktur
 * @property SatuanBarang $satuan
 */
class SalesFakturBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_faktur_barang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_faktur', 'id_barang', 'id_satuan','id_gudang'], 'required'],
            [['id_faktur', 'id_barang', 'jumlah', 'id_satuan'], 'integer'],
            [['created'], 'safe'],
            [['id_barang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['id_barang' => 'id_barang']],
            [['id_faktur'], 'exist', 'skipOnError' => true, 'targetClass' => SalesFaktur::className(), 'targetAttribute' => ['id_faktur' => 'id_faktur']],
            [['id_satuan'], 'exist', 'skipOnError' => true, 'targetClass' => SatuanBarang::className(), 'targetAttribute' => ['id_satuan' => 'id_satuan']],
            [['id_gudang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['id_gudang' => 'id_gudang']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_faktur_barang' => 'Id Faktur Barang',
            'id_faktur' => 'Id Faktur',
            'id_barang' => 'Barang',
            'jumlah' => 'Jumlah',
            'id_satuan' => 'Satuan',
            'id_gudang' => 'Gudang',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaktur()
    {
        return $this->hasOne(SalesFaktur::className(), ['id_faktur' => 'id_faktur']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(SatuanBarang::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getGudang() 
    { 
        return $this->hasOne(SalesGudang::className(), ['id_gudang' => 'id_gudang']); 
    }

    public function getNamaGudang()
    {
        return $this->gudang->nama;
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

}
