<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%barang_opname}}".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $perusahaan_id
 * @property int $departemen_stok_id
 * @property double $stok
 * @property double $stok_riil
 * @property double $stok_lalu
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SalesMasterBarang $barang
 * @property Perusahaan $perusahaan
 * @property DepartemenStok $departemenStok
 */
class BarangOpname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_opname}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'perusahaan_id', 'departemen_stok_id', 'stok_riil', 'bulan', 'tahun', 'tanggal'], 'required'],
            [['barang_id', 'perusahaan_id', 'departemen_stok_id', 'bulan', 'tahun'], 'integer'],
            [['stok', 'stok_riil', 'stok_lalu'], 'number'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['departemen_stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartemenStok::className(), 'targetAttribute' => ['departemen_stok_id' => 'id']],
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
            'perusahaan_id' => 'Perusahaan ID',
            'departemen_stok_id' => 'Departemen Stok ID',
            'stok' => 'Stok',
            'stok_riil' => 'Stok Riil',
            'stok_lalu' => 'Stok Lalu',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenStok()
    {
        return $this->hasOne(DepartemenStok::className(), ['id' => 'departemen_stok_id']);
    }
}
