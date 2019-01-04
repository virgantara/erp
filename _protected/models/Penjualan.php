<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan}}".
 *
 * @property int $id
 * @property string $tanggal
 * @property int $departemen_id
 * @property int $customer_id
 * @property int $is_approved
 * @property string $created_at
 * @property string $updated_at
 */
class Penjualan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penjualan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'departemen_id', 'customer_id'], 'required'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['departemen_id', 'customer_id', 'is_approved'], 'integer'],
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
            'kode_penjualan' => 'Kode Penjualan',
            'departemen_id' => 'Departemen ID',
            'customer_id' => 'Customer ID',
            'is_approved' => 'Is Approved',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
