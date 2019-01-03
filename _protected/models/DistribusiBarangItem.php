<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%distribusi_barang_item}}".
 *
 * @property int $id
 * @property int $distribusi_barang_id
 * @property double $qty
 * @property int $stok_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property DistribusiBarang $distribusiBarang
 * @property SalesStokGudang $stok
 */
class DistribusiBarangItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%distribusi_barang_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['distribusi_barang_id', 'qty', 'stok_id'], 'required'],
            [['distribusi_barang_id', 'stok_id'], 'integer'],
            [['qty'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['distribusi_barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => DistribusiBarang::className(), 'targetAttribute' => ['distribusi_barang_id' => 'id']],
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
            'distribusi_barang_id' => 'Distribusi Barang',
            'qty' => 'Qty',
            'stok_id' => 'Stok Dept',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDistribusiBarang()
    {
        return $this->hasOne(DistribusiBarang::className(), ['id' => 'distribusi_barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStok()
    {
        return $this->hasOne(DepartemenStok::className(), ['id' => 'stok_id']);
    }
}
