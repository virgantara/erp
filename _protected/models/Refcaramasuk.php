<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%a_refcaramasuk}}".
 *
 * @property int $KodeMasuk
 * @property string $NamaMasuk
 *
 * @property BPendaftaran[] $bPendaftarans
 */
class Refcaramasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%a_refcaramasuk}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NamaMasuk'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'KodeMasuk' => 'Kode Masuk',
            'NamaMasuk' => 'Nama Masuk',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBPendaftarans()
    {
        return $this->hasMany(BPendaftaran::className(), ['KodeMasuk' => 'KodeMasuk']);
    }
}
