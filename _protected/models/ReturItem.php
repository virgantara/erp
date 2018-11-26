<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%retur_item}}".
 *
 * @property int $id
 * @property int $retur_id
 * @property int $barang_id
 * @property double $qty
 * @property string $keterangan
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Retur $retur
 * @property SalesMasterBarang $barang
 */
class ReturItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%retur_item}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['retur_id', 'barang_id','exp_date','batch_no'], 'required'],
            [['retur_id', 'barang_id'], 'integer'],
            [['qty'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['keterangan'], 'string', 'max' => 255],
            [['retur_id'], 'exist', 'skipOnError' => true, 'targetClass' => Retur::className(), 'targetAttribute' => ['retur_id' => 'id']],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'retur_id' => 'Retur',
            'barang_id' => 'Barang',
            'faktur_barang_id' => 'Faktur Barang',
            'qty' => 'Qty',
            'exp_date' => 'Exp Date',
            'batch_no' => 'Batch No.',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRetur()
    {
        return $this->hasOne(Retur::className(), ['id' => 'retur_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }
}
