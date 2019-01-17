<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan}}".
 *
 * @property int $id
 * @property string $kode_penjualan
 * @property string $kode_daftar
 * @property string $tanggal
 * @property int $departemen_id
 * @property int $customer_id
 * @property int $is_approved
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Departemen $departemen
 * @property PenjualanItem[] $penjualanItems
 */
class Penjualan extends \yii\db\ActiveRecord
{

    public $tanggal_awal;
    public $tanggal_akhir;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penjualan}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kode_penjualan', // required
                'value' => date('Ymd').'?' , // format auto number. '?' will be replaced with generated number
                'digit' => 4 // optional, default to null. 
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_penjualan', 'tanggal', 'departemen_id', 'customer_id'], 'required'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['departemen_id', 'customer_id', 'is_approved'], 'integer'],
            [['kode_penjualan', 'kode_daftar'], 'string', 'max' => 20],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
            [['kode_penjualan'], 'autonumber', 'format'=>date('Ymd').'?'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_penjualan' => 'Kode Penjualan',
            'kode_daftar' => 'Kode Daftar',
            'tanggal' => 'Tanggal',
            'departemen_id' => 'Departemen ID',
            'customer_id' => 'Customer ID',
            'is_approved' => 'Is Approved',
            'tanggal_awal' => 'Tgl Awal',
            'tanggal_akhir' => 'Tgl Akhir',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemen()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanItems()
    {
        return $this->hasMany(PenjualanItem::className(), ['penjualan_id' => 'id']);
    }
}
