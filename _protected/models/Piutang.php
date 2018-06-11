<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%piutang}}".
 *
 * @property int $id
 * @property string $kwitansi
 * @property string $penanggung_jawab
 * @property int $perkiraan_id
 * @property string $keterangan
 * @property string $tanggal
 * @property double $nilai
 * @property string $created
 * @property int $perusahaan_id
 * @property string $kode_transaksi
 *
 * @property Perkiraan $perkiraan
 * @property Perusahaan $perusahaan
 */
class Piutang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%piutang}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kwitansi', // required
                // 'group' => $this->id_branch, // optional
                'value' => 'KWP.'.date('Y-m-d').'.?' , // format auto number. '?' will be replaced with generated number
                'digit' => 4 // optional, default to null. 
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perkiraan_id', 'keterangan', 'tanggal'], 'required'],
            [['perkiraan_id', 'perusahaan_id'], 'integer'],
            [['keterangan'], 'string'],
            [['tanggal', 'created','is_lunas'], 'safe'],
            [['nilai'], 'number'],
            [['kwitansi'], 'autonumber', 'format'=>'KWP.'.date('Y-m-d').'.?'],
            [['kwitansi', 'kode_transaksi'], 'string', 'max' => 50],
            [['penanggung_jawab'], 'string', 'max' => 255],
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
            'kwitansi' => 'Kwitansi',
            'penanggung_jawab' => 'Penanggung Jawab',
            'perkiraan_id' => 'Perkiraan ID',
            'keterangan' => 'Keterangan',
            'tanggal' => 'Tanggal',
            'nilai' => 'Nilai',
            'created' => 'Created',
            'perusahaan_id' => 'Perusahaan ID',
            'kode_transaksi' => 'Kode Transaksi',
            'is_lunas' => 'Lunas'
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

    public function getNamaPerkiraan()
    {
        return $this->perkiraan->kode.'-'.$this->perkiraan->nama;
    }
}
