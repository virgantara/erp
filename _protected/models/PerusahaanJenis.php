<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan_jenis".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 *
 * @property Perusahaan[] $perusahaans
 */
class PerusahaanJenis extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%perusahaan_jenis}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode', 'nama'], 'required'],
            [['kode'], 'string', 'max' => 50],
            [['nama'], 'string', 'max' => 255],
            [['kode'], 'unique'],
            [['nama'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaans()
    {
        return $this->hasMany(Perusahaan::className(), ['jenis' => 'id']);
    }
}
