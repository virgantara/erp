<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%b_pendaftaran_rinap}}".
 *
 * @property double $Id
 * @property double $NoDaftar
 * @property int $KodePoli
 * @property int $KodeSubPlg
 * @property string $KetPlg
 * @property int $UrutanPoli
 * @property int $KodeTdkLanjut
 * @property int $StatusKunj 1: Kemauan, 2: Konsul
 * @property string $KetTdkL1
 * @property string $KetTdkL2
 * @property string $KetTdkL3
 * @property string $KetTdkL4
 * @property string $KetTdkL5
 * @property int $NoAntriPoli
 * @property string $PostMRS
 *
 * @property BPendaftaran $noDaftar
 */
class PendaftaranRinap extends SimrsModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%b_pendaftaran_rinap}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NoDaftar'], 'number'],
            [['KodePoli', 'KodeSubPlg', 'UrutanPoli', 'KodeTdkLanjut', 'StatusKunj', 'NoAntriPoli'], 'integer'],
            [['KetPlg', 'PostMRS'], 'string', 'max' => 30],
            [['KetTdkL1', 'KetTdkL2', 'KetTdkL3', 'KetTdkL4', 'KetTdkL5'], 'string', 'max' => 50],
            [['NoDaftar'], 'exist', 'skipOnError' => true, 'targetClass' => BPendaftaran::className(), 'targetAttribute' => ['NoDaftar' => 'NODAFTAR']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'NoDaftar' => 'No Daftar',
            'KodePoli' => 'Kode Poli',
            'KodeSubPlg' => 'Kode Sub Plg',
            'KetPlg' => 'Ket Plg',
            'UrutanPoli' => 'Urutan Poli',
            'KodeTdkLanjut' => 'Kode Tdk Lanjut',
            'StatusKunj' => 'Status Kunj',
            'KetTdkL1' => 'Ket Tdk L1',
            'KetTdkL2' => 'Ket Tdk L2',
            'KetTdkL3' => 'Ket Tdk L3',
            'KetTdkL4' => 'Ket Tdk L4',
            'KetTdkL5' => 'Ket Tdk L5',
            'NoAntriPoli' => 'No Antri Poli',
            'PostMRS' => 'Post Mrs',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoDaftar()
    {
        return $this->hasOne(BPendaftaran::className(), ['NODAFTAR' => 'NoDaftar']);
    }
}
