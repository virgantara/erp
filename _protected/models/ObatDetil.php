<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_obat_detil".
 *
 * @property int $id
 * @property int $barang_id
 * @property string $nama_generik
 * @property string $kekuatan
 * @property string $satuan_kekuatan
 * @property string $jns_sediaan
 * @property string $b_i_r
 * @property string $gen_non
 * @property string $nar_p_non
 * @property string $oakrl
 * @property string $kronis
 *
 * @property SalesMasterBarang $barang
 */
class ObatDetil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_obat_detil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id'], 'required'],
            [['barang_id'], 'integer'],
            [['kronis'], 'string'],
            [['nama_generik'], 'string', 'max' => 255],
            [['kekuatan', 'satuan_kekuatan', 'jns_sediaan', 'b_i_r', 'gen_non'], 'string', 'max' => 75],
            [['nar_p_non', 'oakrl'], 'string', 'max' => 50],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang ID',
            'nama_generik' => 'Nama Generik',
            'kekuatan' => 'Kekuatan',
            'satuan_kekuatan' => 'Satuan Kekuatan',
            'jns_sediaan' => 'Jns Sediaan',
            'b_i_r' => 'B I R',
            'gen_non' => 'Gen Non',
            'nar_p_non' => 'Nar P Non',
            'oakrl' => 'Oakrl',
            'kronis' => 'Kronis',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }
}
