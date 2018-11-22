<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "saldo".
 *
 * @property int $id
 * @property double $nilai_awal
 * @property double $nilai_akhir
 * @property int $bulan
 * @property int $tahun
 * @property string $created
 */
class Saldo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%saldo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nilai_awal', 'bulan', 'tahun','jenis','perusahaan_id'], 'required'],
            [['nilai_awal', 'nilai_akhir'], 'number'],
            [['bulan', 'tahun'], 'integer'],
            [['created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nilai_awal' => 'Nilai Awal',
            'nilai_akhir' => 'Nilai Akhir',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'jenis' => 'Jenis',
            'perusahaan_id' => 'Perusahaan',
            'created' => 'Created',
        ];
    }


}
