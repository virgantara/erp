<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_penjualan".
 *
 * @property int $id
 * @property string $tanggal
 * @property int $barang_id
 * @property double $qty
 * @property string $satuan
 * @property double $harga_satuan
 * @property double $harga_total
 * @property int $departemen_id
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 * @property Departemen $departemen
 */
class Penjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_penjualan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'barang_id', 'departemen_id'], 'required'],
            [['tanggal', 'created'], 'safe'],
            [['barang_id', 'departemen_id'], 'integer'],
            [['qty', 'harga_satuan', 'harga_total'], 'number'],
            [['satuan'], 'string', 'max' => 50],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'barang_id' => 'Barang ID',
            'qty' => 'Qty',
            'satuan' => 'Satuan',
            'harga_satuan' => 'Harga Satuan',
            'harga_total' => 'Harga Total',
            'departemen_id' => 'Departemen ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemen()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id']);
    }
}
