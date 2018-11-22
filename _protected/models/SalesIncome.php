<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_income".
 *
 * @property int $id_sales
 * @property int $barang_id
 * @property double $jumlah
 * @property double $harga
 * @property string $tanggal
 * @property string $created
 * @property int $id_perusahaan
 *
 * @property Perusahaan $perusahaan
 */
class SalesIncome extends \yii\db\ActiveRecord
{

    public $id_gudang;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_income}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['stok_id', 'jumlah', 'tanggal', 'id_perusahaan','id_gudang'], 'required'],
            [['stok_id', 'id_perusahaan'], 'integer'],
            [['jumlah', 'harga'], 'number'],
            [['tanggal', 'created'], 'safe'],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
             [['stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesStokGudang::className(), 'targetAttribute' => ['stok_id' => 'id_stok']], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_sales' => 'Id Sales',
            'stok_id' => 'Stok ID',
            'jumlah' => 'Jumlah',
            'harga' => 'Harga',
            'tanggal' => 'Tanggal',
            'created' => 'Created',
            'id_perusahaan' => 'Perusahaan',
            'id_gudang' => 'Gudang'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    public function getStok()
    {
       return $this->hasOne(SalesStokGudang::className(), ['id_stok' => 'stok_id']);
    }

    public function getNamaGudang()
    {
        return $this->stok->gudang->nama;
    }

    public function getNamaBarang()
    {
        return $this->stok->barang->nama_barang;
    }
}
