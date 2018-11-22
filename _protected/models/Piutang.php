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
 * @property double $qty
 * @property string $created
 * @property int $perusahaan_id
 * @property string $kode_transaksi
 * @property int $customer_id
 * @property string $no_nota
 * @property int $is_lunas
 * @property int $barang_id
 * @property double $rupiah
 *
 * @property Customer $customer
 * @property Perkiraan $perkiraan
 * @property SalesMasterBarang $barang
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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kwitansi', 'perkiraan_id', 'keterangan', 'tanggal', 'customer_id', 'barang_id'], 'required'],
            [['perkiraan_id', 'perusahaan_id', 'customer_id', 'is_lunas', 'barang_id'], 'integer'],
            [['keterangan'], 'string'],
            [['tanggal', 'created'], 'safe'],
            [['qty', 'rupiah'], 'number'],
            [['kwitansi', 'kode_transaksi'], 'string', 'max' => 50],
            [['penanggung_jawab', 'no_nota'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['perkiraan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perkiraan::className(), 'targetAttribute' => ['perkiraan_id' => 'id']],
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
            'kwitansi' => 'Kwitansi',
            'penanggung_jawab' => 'Penanggung Jawab',
            'perkiraan_id' => 'Perkiraan ID',
            'keterangan' => 'Keterangan',
            'tanggal' => 'Tanggal',
            'qty' => 'Qty',
            'created' => 'Created',
            'perusahaan_id' => 'Perusahaan ID',
            'kode_transaksi' => 'Kode Transaksi',
            'customer_id' => 'Customer ID',
            'no_nota' => 'No Nota',
            'is_lunas' => 'Is Lunas',
            'barang_id' => 'Barang ID',
            'rupiah' => 'Rupiah',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
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
