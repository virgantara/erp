<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bbm_faktur_item".
 *
 * @property int $id
 * @property int $faktur_id
 * @property int $barang_id
 * @property double $jumlah
 * @property int $stok_id
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 * @property BbmFaktur $faktur
 * @property SalesStokGudang $stok
 */
class BbmFakturItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bbm_faktur_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faktur_id', 'barang_id', 'stok_id','harga'], 'required'],
            [['faktur_id', 'barang_id', 'stok_id'], 'integer'],
            [['jumlah','harga'], 'number'],
            [['created'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['faktur_id'], 'exist', 'skipOnError' => true, 'targetClass' => BbmFaktur::className(), 'targetAttribute' => ['faktur_id' => 'id']],
            [['stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesStokGudang::className(), 'targetAttribute' => ['stok_id' => 'id_stok']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faktur_id' => 'Faktur ID',
            'barang_id' => 'Barang ID',
            'jumlah' => 'Jumlah',
            'stok_id' => 'Stok ID',
            'created' => 'Created',
            'harga' => 'Harga Total'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    public function getSatuan(){
        return $this->barang->id_satuan;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaktur()
    {
        return $this->hasOne(BbmFaktur::className(), ['id' => 'faktur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStok()
    {
        return $this->hasOne(SalesStokGudang::className(), ['id_stok' => 'stok_id']);
    }

    public function getNamaGudang(){
        return $this->stok->gudang->nama;
    }
}
