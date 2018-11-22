<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "neraca".
 *
 * @property int $id
 * @property int $perkiraan_id
 * @property double $nominal
 * @property int $bulan
 * @property int $tahun
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Perkiraan $perkiraan
 * @property Perusahaan $perusahaan
 */
class Neraca extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%neraca}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perkiraan_id', 'nominal', 'bulan', 'tahun', 'perusahaan_id'], 'required'],
            [['perkiraan_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['nominal'], 'number'],
            [['created'], 'safe'],
            [['perkiraan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perkiraan::className(), 'targetAttribute' => ['perkiraan_id' => 'id']],
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
            'perkiraan_id' => 'Perkiraan ID',
            'nominal' => 'Nominal',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerkiraan()
    {
        return $this->hasOne(Perkiraan::className(), ['id' => 'perkiraan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
