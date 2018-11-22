<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_stok_awal".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $gudang_id
 * @property int $perusahaan_id
 * @property string $tanggal
 * @property string $bulan
 * @property int $tahun
 * @property string $created
 * @property double $jumlah
 *
 * @property SalesMasterBarang $barang
 * @property SalesMasterGudang $gudang
 * @property Perusahaan $perusahaan
 */
class StokAwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_stok_awal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'gudang_id', 'perusahaan_id', 'tanggal'], 'required'],
            [['barang_id', 'gudang_id', 'perusahaan_id', 'tahun'], 'integer'],
            [['tanggal', 'created'], 'safe'],
            [['jumlah'], 'number'],
            [['bulan'], 'string', 'max' => 2],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['gudang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['gudang_id' => 'id_gudang']],
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
            'barang_id' => 'Barang',
            'gudang_id' => 'Gudang',
            'perusahaan_id' => 'PerusahaanD',
            'tanggal' => 'Tanggal',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'created' => 'Created',
            'jumlah' => 'Jumlah',
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
    public function getGudang()
    {
        return $this->hasOne(SalesGudang::className(), ['id_gudang' => 'gudang_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->tanggal = date('Y-m-d',strtotime($this->tanggal));
        $this->bulan = date('m',strtotime($this->tanggal));
        $this->tahun = date('Y',strtotime($this->tanggal));
        // $this->tanggal_tempo = date('Y-m-d',strtotime($this->tanggal_tempo));
        return true;
    }

    public function afterFind(){
        parent::afterFind();

        $this->tanggal = date('d-M-Y',strtotime($this->tanggal));
    }

    public static function getStokAwal($bulan, $tahun, $barang_id){
        $prevDate = date('Y-m-d',strtotime($tahun.'-'.$bulan.'-01 -1 month'));
        $query = StokAwal::find()->where([
            'barang_id' => $barang_id,
        ]);

        $lastDate = date('Y-m-d',strtotime(date('t').'-'.$bulan.'-'.$tahun.' -1 month'));
        $query->andWhere(['between','tanggal',$prevDate,$lastDate]);

        $total = 0;
        foreach($query->all() as $item)
            $total += $item->jumlah;

        return $total;
    }   
}
