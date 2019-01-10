<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%produksi}}".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $parent_id
 * @property double $kekuatan
 * @property double $dosis_minta
 * @property double $jumlah
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SalesMasterBarang $barang
 * @property SalesMasterBarang $parent
 */
class Produksi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%produksi}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'parent_id', 'kekuatan'], 'required'],
            [['barang_id'], 'integer'],
            [['kekuatan', 'dosis_minta', 'jumlah'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['parent_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang ID',
            'parent_id' => 'Parent ID',
            'kekuatan' => 'Kekuatan',
            'dosis_minta' => 'Dosis Minta',
            'jumlah' => 'Jumlah',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getParent()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'parent_id']);
    }
}
