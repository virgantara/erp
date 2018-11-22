<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%barang_rekap}}".
 *
 * @property int $id
 * @property double $tebus_liter
 * @property double $tebus_rupiah
 * @property double $dropping
 * @property double $sisa_do
 * @property double $jual_liter
 * @property double $jual_rupiah
 * @property double $stok_adm
 * @property double $stok_riil
 * @property double $loss
 * @property string $tanggal
 * @property int $barang_id
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 * @property Perusahaan $perusahaan
 */
class BarangRekap extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_rekap}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tebus_liter', 'tebus_rupiah', 'dropping', 'sisa_do', 'jual_liter', 'jual_rupiah', 'stok_adm', 'stok_riil', 'loss'], 'number'],
            [['tanggal', 'barang_id', 'perusahaan_id'], 'required'],
            [['tanggal', 'created','is_loss'], 'safe'],
            [['barang_id', 'perusahaan_id'], 'integer'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
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
            'tebus_liter' => 'Tebus Liter',
            'tebus_rupiah' => 'Tebus Rupiah',
            'dropping' => 'Dropping',
            'sisa_do' => 'Sisa Do',
            'jual_liter' => 'Jual Liter',
            'jual_rupiah' => 'Jual Rupiah',
            'stok_adm' => 'Stok Adm',
            'stok_riil' => 'Stok Riil',
            'loss' => 'Loss',
            'tanggal' => 'Tanggal',
            'barang_id' => 'Barang ID',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
            'is_loss' => 'Is Loss'
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
}
