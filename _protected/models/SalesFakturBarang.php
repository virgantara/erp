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
            [['id_faktur', 'id_barang', 'id_satuan','id_gudang','harga_netto','harga_beli','ppn','diskon','exp_date','no_batch'], 'required'],
            [['id_faktur', 'id_barang', 'jumlah'], 'integer'],
            [['created'], 'safe'],
            [['id_barang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['id_barang' => 'id_barang']],
            [['id_faktur'], 'exist', 'skipOnError' => true, 'targetClass' => SalesFaktur::className(), 'targetAttribute' => ['id_faktur' => 'id_faktur']],
           
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
            'jumlah' => 'Qty',
            'id_satuan' => 'Satuan',
            'id_gudang' => 'Gudang',
            'created' => 'Created',
            'ppn' => 'PPn (%)',
            'no_batch' => 'Batch No',
            'kode_barang' => 'Kode Barang',
            'harga_beli' => 'HB',
            'harga_jual' => 'HJ',
            'harga_netto'=> 'HNA',
            'diskon' => 'Disc. (%)'
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

       
        if(!empty($this->tanggal_lo))
            $this->tanggal_lo = date('Y-m-d', strtotime($this->tanggal_lo));

        return true;
    }

    public function afterFind(){
        parent::afterFind();

        // $this->harga_netto = number_format($this->harga_netto, 2,',','.');
        // $this->harga_beli = number_format($this->harga_beli, 2,',','.');
        // $this->diskon = number_format($this->diskon, 2,',','.');
        // $this->ppn = number_format($this->ppn, 2,',','.');
        // $this->harga_jual = number_format($this->harga_jual, 2,',','.');
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
