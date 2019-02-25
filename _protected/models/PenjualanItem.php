<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan_item}}".
 *
 * @property int $id
 * @property int $penjualan_id
 * @property int $stok_id
 * @property string $kode_racikan
 * @property double $qty
 * @property double $kekuatan
 * @property double $dosis_minta
 * @property double $jumlah_ke_apotik
 * @property double $jumlah_hari
 * @property int $signa1
 * @property int $signa2
 * @property double $harga
 * @property double $subtotal
 * @property double $diskon
 * @property double $ppn
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Penjualan $penjualan
 * @property DepartemenStok $stok
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
            [['penjualan_id', 'stok_id','harga','harga_beli'], 'required'],
            [['penjualan_id', 'stok_id', 'signa1', 'signa2'], 'integer'],
            [['qty', 'kekuatan', 'dosis_minta', 'jumlah_ke_apotik', 'jumlah_hari', 'harga', 'subtotal', 'diskon', 'ppn','is_racikan'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_racikan'], 'string', 'max' => 20],
            [['penjualan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Penjualan::className(), 'targetAttribute' => ['penjualan_id' => 'id']],
            [['stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartemenStok::className(), 'targetAttribute' => ['stok_id' => 'id']],
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
            'kode_racikan' => 'Kode Racikan',
            'qty' => 'Qty',
            'kekuatan' => 'Kekuatan',
            'dosis_minta' => 'Dosis Minta',
            'jumlah_ke_apotik' => 'Jml Ke Apotik',
            'jumlah_hari' => 'Jml Hari',
            'signa1' => 'Signa 1',
            'signa2' => 'Signa 2',
            'harga' => 'Harga',
            'subtotal' => 'Subtotal',
            'diskon' => 'Diskon',
            'ppn' => 'PPn',
            'harga_beli' => 'Harga Beli',
            'is_racikan' => 'Is Racikan',
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
        return $this->hasOne(DepartemenStok::className(), ['id' => 'stok_id']);
    }
}
