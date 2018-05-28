<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_stok_gudang".
 *
 * @property int $id_stok
 * @property int $id_gudang
 * @property int $id_barang
 * @property double $jumlah
 * @property string $created
 *
 * @property SalesIncome[] $salesIncomes
 * @property SalesMasterBarang $barang
 * @property SalesMasterGudang $gudang
 */
class SalesStokGudang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_stok_gudang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gudang', 'id_barang', 'jumlah'], 'required'],
            [['id_gudang', 'id_barang'], 'integer'],
            [['jumlah'], 'number'],
            [['created'], 'safe'],
            [['id_barang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesBarang::className(), 'targetAttribute' => ['id_barang' => 'id_barang']],
            [['id_gudang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['id_gudang' => 'id_gudang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok' => 'Id Stok',
            'id_gudang' => 'Gudang',
            'id_barang' => 'Barang',
            'jumlah' => 'Jumlah',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesIncomes()
    {
        return $this->hasMany(SalesIncome::className(), ['stok_id' => 'id_stok']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesBarang::className(), ['id_barang' => 'id_barang']);
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
