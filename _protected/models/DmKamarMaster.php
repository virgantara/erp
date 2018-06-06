<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_kamar_master".
 *
 * @property int $id
 * @property string $nama_kamar
 * @property string $kode_kamar
 *
 * @property DmKamar[] $dmKamars
 */
class DmKamarMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_kamar_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kamar'], 'required'],
            [['nama_kamar'], 'string', 'max' => 50],
            [['kode_kamar'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_kamar' => 'Nama Kamar',
            'kode_kamar' => 'Kode Kamar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmKamars()
    {
        return $this->hasMany(DmKamar::className(), ['kamar_master_id' => 'id']);
    }
}
