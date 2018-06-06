<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obat_alkes".
 *
 * @property int $id_obat_alkes
 * @property string $kode_alkes
 * @property string $nama_obat_alkes
 * @property int $kelas_id
 * @property double $bhp
 * @property double $jrs dalam rupiah
 * @property double $japel dalam rupiah
 * @property double $tarip
 * @property string $param jenis tindakan, contoh : non operatif, bidan, gigi, dsb
 * @property string $catatan
 * @property string $created
 *
 * @property DmKelas $kelas
 * @property TrRawatInapAlkes[] $trRawatInapAlkes
 */
class ObatAlkes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obat_alkes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_obat_alkes', 'kelas_id', 'jrs', 'japel', 'tarip', 'param'], 'required'],
            [['kelas_id'], 'integer'],
            [['bhp', 'jrs', 'japel', 'tarip'], 'number'],
            [['created'], 'safe'],
            [['kode_alkes'], 'string', 'max' => 20],
            [['nama_obat_alkes', 'param', 'catatan'], 'string', 'max' => 255],
            [['kelas_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmKelas::className(), 'targetAttribute' => ['kelas_id' => 'id_kelas']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_obat_alkes' => 'Id Obat Alkes',
            'kode_alkes' => 'Kode Alkes',
            'nama_obat_alkes' => 'Nama Obat Alkes',
            'kelas_id' => 'Kelas ID',
            'bhp' => 'Bhp',
            'jrs' => 'Jrs',
            'japel' => 'Japel',
            'tarip' => 'Tarip',
            'param' => 'Param',
            'catatan' => 'Catatan',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKelas()
    {
        return $this->hasOne(DmKelas::className(), ['id_kelas' => 'kelas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInapAlkes()
    {
        return $this->hasMany(TrRawatInapAlkes::className(), ['id_alkes' => 'id_obat_alkes']);
    }
}
