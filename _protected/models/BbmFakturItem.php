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
            [['faktur_id', 'barang_id','harga','pph'], 'required'],
            [['faktur_id', 'barang_id'], 'integer'],
            [['jumlah','harga'], 'number'],
            [['created'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['faktur_id'], 'exist', 'skipOnError' => true, 'targetClass' => BbmFaktur::className(), 'targetAttribute' => ['faktur_id' => 'id']],
           
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
            'pph' => 'PPh',
            'created' => 'Created',
            'harga' => 'Harga Penebusan',
            
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
  

    // public function getNamaGudang(){
    //     return $this->stok->gudang->nama;
    // }

      public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // $this->tanggal_lo = date('Y-m-d',strtotime($this->tanggal_lo));
      
        // $this->tanggal_tempo = date('Y-m-d',strtotime($this->tanggal_tempo));
        return true;
    }

     public function afterFind(){
        parent::afterFind();

        // $this->tanggal_lo = date('d-m-Y',strtotime($this->tanggal_lo));
    }
}
