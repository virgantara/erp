<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tr_rawat_inap_alkes_obat}}".
 *
 * @property int $id
 * @property int $id_rawat_inap
 * @property string $kode_alkes
 * @property string $keterangan
 * @property double $nilai
 * @property string $created
 * @property string $id_m_obat_akhp
 * @property string $tanggal_input
 * @property int $id_dokter
 * @property int $jumlah
 * @property string $satuan
 * @property int $resep_non_racik_id
 * @property int $resep_racik_id
 *
 * @property TrRawatInap $rawatInap
 * @property DmDokter $dokter
 */
class RawatInapAlkesObat extends SimrsModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tr_rawat_inap_alkes_obat}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rawat_inap', 'kode_alkes'], 'required'],
            [['id_rawat_inap', 'id_dokter', 'jumlah', 'resep_non_racik_id', 'resep_racik_id'], 'integer'],
            [['nilai'], 'number'],
            [['created', 'tanggal_input'], 'safe'],
            [['kode_alkes'], 'string', 'max' => 20],
            [['keterangan'], 'string', 'max' => 255],
            [['id_m_obat_akhp', 'satuan'], 'string', 'max' => 50],
            [['id_rawat_inap'], 'exist', 'skipOnError' => true, 'targetClass' => TrRawatInap::className(), 'targetAttribute' => ['id_rawat_inap' => 'id_rawat_inap']],
            [['id_dokter'], 'exist', 'skipOnError' => true, 'targetClass' => DmDokter::className(), 'targetAttribute' => ['id_dokter' => 'id_dokter']],
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
            'id_m_obat_akhp' => 'Id M Obat Akhp',
            'tanggal_input' => 'Tanggal Input',
            'id_dokter' => 'Id Dokter',
            'jumlah' => 'Jumlah',
            'satuan' => 'Satuan',
            'resep_non_racik_id' => 'Resep Non Racik ID',
            'resep_racik_id' => 'Resep Racik ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawatInap()
    {
        return $this->hasOne(TrRawatInap::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDokter()
    {
        return $this->hasOne(DmDokter::className(), ['id_dokter' => 'id_dokter']);
    }
}
