<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%retur}}".
 *
 * @property int $id
 * @property int $faktur_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SalesFaktur $faktur
 * @property ReturItem[] $returItems
 */
class Retur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%retur}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faktur_id'], 'required'],
            [['faktur_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['faktur_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesFaktur::className(), 'targetAttribute' => ['faktur_id' => 'id_faktur']],
            [['suplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesSuplier::className(), 'targetAttribute' => ['suplier_id' => 'id_suplier']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'faktur_id' => 'Faktur',
            'suplier_id' => 'Suplier',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_approved' => 'Approval'
        ];
    }

    public function getNamaSuplier()
    {
      return $this->suplier->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFaktur()
    {
        return $this->hasOne(SalesFaktur::className(), ['id_faktur' => 'faktur_id']);
    }

    public function getSuplier()
    {
        return $this->hasOne(SalesSuplier::className(), ['id_suplier' => 'suplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReturItems()
    {
        return $this->hasMany(ReturItem::className(), ['retur_id' => 'id']);
    }
}
