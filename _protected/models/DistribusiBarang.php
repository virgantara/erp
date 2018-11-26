<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%distribusi_barang}}".
 *
 * @property int $id
 * @property int $departemen_id
 * @property string $tanggal
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Departemen $departemen
 * @property DistribusiBarangItem[] $distribusiBarangItems
 */
class DistribusiBarang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%distribusi_barang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departemen_id', 'tanggal'], 'required'],
            [['departemen_id'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departemen_id' => 'Unit Tujuan',
            'tanggal' => 'Tanggal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_approved' => 'Approval',
            'departemenTujuan' => 'Unit Tujuan'
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
    public function getDistribusiBarangItems()
    {
        return $this->hasMany(DistribusiBarangItem::className(), ['distribusi_barang_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->tanggal = date('Y-m-d',strtotime($this->tanggal));


        return true;
    }

    public function getDepartemenTujuan(){

        return $this->departemen->nama;
    }
}
