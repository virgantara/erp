<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string $nama
 * @property string $telp
 * @property string $alamat
 * @property int $perusahaan_id
 *
 * @property Perusahaan $perusahaan
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'perusahaan_id'], 'required'],
            [['perusahaan_id'], 'integer'],
            [['nama', 'alamat'], 'string', 'max' => 255],
            [['telp'], 'string', 'max' => 50],
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
            'nama' => 'Nama',
            'telp' => 'Telp',
            'alamat' => 'Alamat',
            'perusahaan_id' => 'Perusahaan ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
