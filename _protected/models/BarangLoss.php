<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%barang_loss}}".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property string $jam
 * @property double $stok_adm
 * @property double $stok_riil
 * @property double $loss
 * @property double $biaya_loss
 * @property string $created
 * @property int $perusahaan_id
 *
 * @property SalesMasterBarang $barang
 * @property Perusahaan $perusahaan
 */
class BarangLoss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_loss}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'bulan', 'tahun', 'tanggal', 'jam', 'perusahaan_id'], 'required'],
            [['barang_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['tanggal', 'jam', 'created','kode_transaksi'], 'safe'],
            [['stok_adm', 'stok_riil', 'loss', 'biaya_loss'], 'number'],
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
            'barang_id' => 'Barang ID',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal',
            'jam' => 'Jam',
            'stok_adm' => 'Stok Adm',
            'stok_riil' => 'Stok Riil',
            'loss' => 'Loss',
            'biaya_loss' => 'Biaya Loss',
            'created' => 'Created',
            'perusahaan_id' => 'Perusahaan ID',
            'kode_transaksi' => 'Kode Transaksi'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kode_transaksi', // required
                // 'group' => $this->id_branch, // optional
                'value' => 'LS.'.date('Y-m-d').'.?' , // format auto number. '?' will be replaced with generated number
                'digit' => 4 // optional, default to null. 
            ],
            
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
