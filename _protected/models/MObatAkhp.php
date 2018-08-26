<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "m_obat_akhp".
 *
 * @property string $kd_t
 * @property string $kd_barang
 * @property string $kd_js
 * @property string $nama_barang
 * @property string $nama_generik
 * @property string $kekuatan
 * @property string $satuan_kekuatan
 * @property string $satuan
 * @property string $jns_sediaan
 * @property string $b_i_r
 * @property string $gen_non
 * @property string $nar_p_non
 * @property string $oakrl
 * @property string $kronis
 * @property int $stok
 * @property int $stok_min
 * @property double $hb
 * @property double $hna
 * @property int $diskon
 * @property double $hj
 */
class MObatAkhp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm_obat_akhp';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kd_t', 'kd_barang'], 'required'],
            [['stok', 'stok_min', 'diskon'], 'integer'],
            [['hb', 'hna', 'hj'], 'number'],
            [['kd_t', 'kd_barang', 'kd_js'], 'string', 'max' => 20],
            [['nama_barang', 'nama_generik'], 'string', 'max' => 200],
            [['kekuatan', 'satuan_kekuatan', 'satuan', 'jns_sediaan', 'b_i_r', 'gen_non', 'nar_p_non', 'oakrl', 'kronis'], 'string', 'max' => 75],
            [['kd_barang'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'kd_t' => 'Kd T',
            'kd_barang' => 'Kd Barang',
            'kd_js' => 'Kd Js',
            'nama_barang' => 'Nama Barang',
            'nama_generik' => 'Nama Generik',
            'kekuatan' => 'Kekuatan',
            'satuan_kekuatan' => 'Satuan Kekuatan',
            'satuan' => 'Satuan',
            'jns_sediaan' => 'Jns Sediaan',
            'b_i_r' => 'B I R',
            'gen_non' => 'Gen Non',
            'nar_p_non' => 'Nar P Non',
            'oakrl' => 'Oakrl',
            'kronis' => 'Kronis',
            'stok' => 'Stok',
            'stok_min' => 'Stok Min',
            'hb' => 'Hb',
            'hna' => 'Hna',
            'diskon' => 'Diskon',
            'hj' => 'Hj',
        ];
    }
}
