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
            [['departemen_to_id', 'tanggal'], 'required'],
            [['departemen_from_id','departemen_to_id'], 'integer'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['departemen_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_from_id' => 'id']],
            [['departemen_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_to_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departemen_from_id' => 'Unit Asal',
            'departemen_to_id' => 'Unit Tujuan',
            'tanggal' => 'Tanggal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_approved' => 'Approval',
            'namaDepartemenTo' => 'Unit Tujuan',
            'namaDepartemenFrom' => 'Unit Asal'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenFrom()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_from_id']);
    }

    public function getDepartemenTo()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_to_id']);
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

    public function getNamaDepartemenTo(){

        return $this->departemenTo->nama;
    }

    public function getNamaDepartemenFrom(){

        return $this->departemenFrom->nama;
    }
}
