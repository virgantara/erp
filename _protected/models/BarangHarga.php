<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang_harga".
 *
 * @property int $id
 * @property int $barang_id
 * @property double $harga_beli
 * @property double $harga_jual
 * @property int $pilih
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 */
class BarangHarga extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_harga}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'harga_beli', 'harga_jual'], 'required'],
            [['barang_id', 'pilih'], 'integer'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['created'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang',
            'harga_beli' => 'Harga Beli',
            'harga_jual' => 'Harga Jual',
            'pilih' => 'Pilih',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesBarang::className(), ['id_barang' => 'barang_id']);
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }
}
