<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan".
 *
 * @property int $id_perusahaan
 * @property string $nama
 * @property string $email
 * @property string $alamat
 * @property string $telp
 * @property int $jenis
 * @property int $level
 * @property int $created_at
 * @property int $updated_at
 *
 * @property PerusahaanJenis $jenis0
 */
class Perusahaan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perusahaan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'email', 'alamat', 'telp', 'jenis', 'level'], 'required'],
            [['jenis', 'level', 'created_at', 'updated_at'], 'integer'],
            [['nama', 'email', 'alamat', 'telp'], 'string', 'max' => 255],
            [['nama'], 'unique'],
            [['jenis'], 'exist', 'skipOnError' => true, 'targetClass' => PerusahaanJenis::className(), 'targetAttribute' => ['jenis' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_perusahaan' => 'Id Perusahaan',
            'nama' => 'Nama',
            'email' => 'Email',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'jenis' => 'Jenis',
            'level' => 'Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJenis0()
    {
        return $this->hasOne(PerusahaanJenis::className(), ['id' => 'jenis']);
    }

    public function getJenisPerusahaan()
    {
        return $this->jenis0->nama;
    }
}
