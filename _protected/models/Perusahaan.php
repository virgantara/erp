<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan".
 *
 * @property integer $id_perusahaan
 * @property string $nama
 * @property string $email
 * @property string $alamat
 * @property string $telp
 * @property string $jenis
 * @property integer $level
 * @property integer $created_at
 * @property integer $updated_at
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
            [['level', 'created_at', 'updated_at'], 'integer'],
            [['nama', 'email', 'alamat', 'telp', 'jenis'], 'string', 'max' => 255],
            [['nama'], 'unique'],
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
}
