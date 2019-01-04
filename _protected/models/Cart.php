<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cart}}".
 *
 * @property int $id
 * @property string $kode_transaksi
 * @property int $departemen_stok_id
 * @property double $qty
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
            [['departemen_stok_id'], 'integer'],
            [['qty'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode_transaksi'], 'string', 'max' => 20],
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
            'departemen_stok_id' => 'Departemen Stok ID',
            'qty' => 'Qty',
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
