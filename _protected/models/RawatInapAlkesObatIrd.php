<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tr_rawat_inap_alkes_obat_ird}}".
 *
 * @property int $id
 * @property int $id_rawat_inap
 * @property string $kode_alkes
 * @property string $keterangan
 * @property double $nilai
 * @property string $created
 */
class RawatInapAlkesObatIrd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tr_rawat_inap_alkes_obat_ird}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rawat_inap', 'kode_alkes'], 'required'],
            [['id_rawat_inap'], 'integer'],
            [['nilai'], 'number'],
            [['created'], 'safe'],
            [['kode_alkes'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_rawat_inap' => 'Id Rawat Inap',
            'kode_alkes' => 'Kode Alkes',
            'keterangan' => 'Keterangan',
            'nilai' => 'Nilai',
            'created' => 'Created',
        ];
    }
}
