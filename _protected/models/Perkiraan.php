<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perkiraan".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property int $parent
 * @property int $perusahaan_id
 *
 * @property Kas[] $kas
 * @property Perkiraan $parent0
 * @property Perkiraan[] $perkiraans
 * @property Perusahaan $perusahaan
 */
class Perkiraan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perkiraan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'parent'], 'required'],
            [['parent', 'perusahaan_id'], 'integer'],
            [['kode'], 'string', 'max' => 20],
            [['nama'], 'string', 'max' => 100],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => Perkiraan::className(), 'targetAttribute' => ['parent' => 'id']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'parent' => 'Parent',
            'perusahaan_id' => 'Perusahaan ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKas()
    {
        return $this->hasMany(Kas::className(), ['perkiraan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(Perkiraan::className(), ['id' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerkiraans()
    {
        return $this->hasMany(Perkiraan::className(), ['parent' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
