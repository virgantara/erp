<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property int $id
 * @property string $kode_transaksi
 * @property string $kode_racikan
 * @property int $departemen_stok_id
 * @property double $qty
 * @property double $harga
 * @property double $kekuatan
 * @property double $dosis_minta
 * @property double $subtotal
 * @property double $jumlah_ke_apotik
 * @property int $jumlah_hari
 * @property int $signa1
 * @property int $signa2
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DepartemenStok $departemenStok
 */
class Cart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_transaksi', 'departemen_stok_id', 'qty'], 'required'],
            [['departemen_stok_id', 'jumlah_hari', 'signa1', 'signa2','is_racikan'], 'integer'],
            [['qty', 'harga', 'kekuatan', 'dosis_minta', 'subtotal', 'jumlah_ke_apotik'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_transaksi', 'kode_racikan'], 'string', 'max' => 20],
            [['departemen_stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartemenStok::className(), 'targetAttribute' => ['departemen_stok_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_transaksi' => 'Kode Transaksi',
            'kode_racikan' => 'Kode Racikan',
            'departemen_stok_id' => 'Departemen Stok ID',
            'qty' => 'Qty',
            'harga' => 'Harga',
            'is_racikan' => 'Is Racikan',
            'kekuatan' => 'Kekuatan',
            'dosis_minta' => 'Dosis Minta',
            'subtotal' => 'Subtotal',
            'jumlah_ke_apotik' => 'Jumlah Ke Apotik',
            'jumlah_hari' => 'Jumlah Hari',
            'signa1' => 'Signa1',
            'signa2' => 'Signa2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenStok()
    {
        return $this->hasOne(DepartemenStok::className(), ['id' => 'departemen_stok_id']);
    }
}
