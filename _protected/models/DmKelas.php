<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_kelas".
 *
 * @property int $id_kelas
 * @property string $kode_kelas
 * @property string $nama_kelas
 * @property string $kode_kelas_bpjs
 *
 * @property DmKamar[] $dmKamars
 * @property ObatAlkes[] $obatAlkes
 */
class DmKelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_kelas', 'nama_kelas'], 'required'],
            [['kode_kelas'], 'string', 'max' => 5],
            [['nama_kelas'], 'string', 'max' => 100],
            [['kode_kelas_bpjs'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kelas' => 'Id Kelas',
            'kode_kelas' => 'Kode Kelas',
            'nama_kelas' => 'Nama Kelas',
            'kode_kelas_bpjs' => 'Kode Kelas Bpjs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDmKamars()
    {
        return $this->hasMany(DmKamar::className(), ['kelas_id' => 'id_kelas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObatAlkes()
    {
        return $this->hasMany(ObatAlkes::className(), ['kelas_id' => 'id_kelas']);
    }
}
