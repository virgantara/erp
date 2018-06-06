<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dm_kamar".
 *
 * @property int $id_kamar
 * @property int $kelas_id
 * @property string $nama_kamar
 * @property int $tingkat_kamar
 * @property double $biaya_kamar
 * @property double $biaya_askep
 * @property double $biaya_asnut
 * @property int $jumlah_kasur
 * @property int $terpakai
 * @property string $created
 * @property string $user_kamar
 * @property int $is_hapus
 * @property int $kamar_master_id
 *
 * @property DmKelas $kelas
 * @property DmKamarMaster $kamarMaster
 * @property TrRawatInap[] $trRawatInaps
 */
class DmKamar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_kamar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kelas_id', 'nama_kamar', 'biaya_kamar', 'biaya_askep'], 'required'],
            [['kelas_id', 'tingkat_kamar', 'jumlah_kasur', 'terpakai', 'is_hapus', 'kamar_master_id'], 'integer'],
            [['biaya_kamar', 'biaya_askep', 'biaya_asnut'], 'number'],
            [['created'], 'safe'],
            [['nama_kamar'], 'string', 'max' => 255],
            [['user_kamar'], 'string', 'max' => 50],
            [['kelas_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmKelas::className(), 'targetAttribute' => ['kelas_id' => 'id_kelas']],
            [['kamar_master_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmKamarMaster::className(), 'targetAttribute' => ['kamar_master_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_kamar' => 'Id Kamar',
            'kelas_id' => 'Kelas ID',
            'nama_kamar' => 'Nama Kamar',
            'tingkat_kamar' => 'Tingkat Kamar',
            'biaya_kamar' => 'Biaya Kamar',
            'biaya_askep' => 'Biaya Askep',
            'biaya_asnut' => 'Biaya Asnut',
            'jumlah_kasur' => 'Jumlah Kasur',
            'terpakai' => 'Terpakai',
            'created' => 'Created',
            'user_kamar' => 'User Kamar',
            'is_hapus' => 'Is Hapus',
            'kamar_master_id' => 'Kamar Master ID',
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
    public function getKamarMaster()
    {
        return $this->hasOne(DmKamarMaster::className(), ['id' => 'kamar_master_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrRawatInaps()
    {
        return $this->hasMany(TrRawatInap::className(), ['kamar_id' => 'id_kamar']);
    }
}
