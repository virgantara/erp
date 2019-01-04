<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%a_refcarapulangdtl}}".
 *
 * @property int $KodeSub
 * @property int $KodePulang
 * @property string $NamaSub
 *
 * @property BPendaftaran[] $bPendaftarans
 * @property BPendaftaranRjalan[] $bPendaftaranRjalans
 */
class Refcarapulangdtl extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%a_refcarapulangdtl}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['KodePulang'], 'required'],
            [['KodePulang'], 'integer'],
            [['NamaSub'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodeSub' => 'Kode Sub',
            'KodePulang' => 'Kode Pulang',
            'NamaSub' => 'Nama Sub',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftarans()
    {
        return $this->hasMany(BPendaftaran::className(), ['KodeSubPulang' => 'KodeSub']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftaranRjalans()
    {
        return $this->hasMany(BPendaftaranRjalan::className(), ['KodeSubPlg' => 'KodeSub']);
    }
}
