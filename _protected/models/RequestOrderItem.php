<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_order_item".
 *
 * @property int $id
 * @property int $ro_id
 * @property int $stok_id
 * @property double $jumlah_minta
 * @property double $jumlah_beri
 * @property string $satuan
 * @property string $keterangan
 * @property string $created
 * @property int $item_id
 *
 * @property SalesMasterBarang $item
 * @property SalesStokGudang $stok
 * @property RequestOrder $ro
 */
class RequestOrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request_order_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ro_id', 'stok_id', 'jumlah_minta', 'satuan', 'keterangan', 'item_id'], 'required'],
            [['ro_id', 'stok_id', 'item_id'], 'integer'],
            [['jumlah_minta', 'jumlah_beri'], 'number'],
            [['created'], 'safe'],
            [['satuan'], 'string', 'max' => 50],
            [['keterangan'], 'string', 'max' => 255],
            [['item_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['item_id' => 'id_barang']],
            [['stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesStokGudang::className(), 'targetAttribute' => ['stok_id' => 'id_stok']],
            [['ro_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrder::className(), 'targetAttribute' => ['ro_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ro_id' => 'Ro ID',
            'stok_id' => 'Stok ID',
            'jumlah_minta' => 'Jumlah Minta',
            'jumlah_beri' => 'Jumlah Beri',
            'satuan' => 'Satuan',
            'keterangan' => 'Keterangan',
            'created' => 'Created',
            'item_id' => 'Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStok()
    {
        return $this->hasOne(SalesStokGudang::className(), ['id_stok' => 'stok_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRo()
    {
        return $this->hasOne(RequestOrder::className(), ['id' => 'ro_id']);
    }
}
