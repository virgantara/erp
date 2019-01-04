<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan_item}}".
 *
 * @property int $id
 * @property int $penjualan_id
 * @property int $stok_id
 * @property double $qty
 * @property double $harga
 * @property double $subtotal
 * @property double $diskon
 * @property double $ppn
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Penjualan $penjualan
 * @property SalesStokGudang $stok
 */
class PenjualanItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penjualan_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['penjualan_id', 'stok_id'], 'required'],
            [['penjualan_id', 'stok_id'], 'integer'],
            [['qty', 'harga', 'subtotal', 'diskon', 'ppn'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['penjualan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan_id' => 'id']],
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
            'penjualan_id' => 'Penjualan ID',
            'stok_id' => 'Stok ID',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'subtotal' => 'Subtotal',
            'diskon' => 'Diskon',
            'ppn' => 'Ppn',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualan()
    {
        return $this->hasOne(Penjualan::className(), ['id' => 'penjualan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStok()
    {
        return $this->hasOne(SalesStokGudang::className(), ['id_stok' => 'stok_id']);
    }
}
