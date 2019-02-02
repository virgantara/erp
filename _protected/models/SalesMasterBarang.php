<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%sales_master_barang}}".
 *
 * @property int $id_barang
 * @property string $nama_barang
 * @property double $harga_beli
 * @property double $harga_jual
 * @property int $id_satuan
 * @property string $created
 * @property int $id_perusahaan
 * @property int $is_hapus
 *
 * @property BarangDatang[] $barangDatangs
 * @property BarangHarga[] $barangHargas
 * @property BarangLoss[] $barangLosses
 * @property BarangRekap[] $barangRekaps
 * @property BarangStok[] $barangStoks
 * @property BarangStokOpname[] $barangStokOpnames
 * @property BbmDispenser[] $bbmDispensers
 * @property BbmFakturItem[] $bbmFakturItems
 * @property BbmJual[] $bbmJuals
 * @property DepartemenStok[] $departemenStoks
 * @property RequestOrderItem[] $requestOrderItems
 * @property SalesFakturBarang[] $salesFakturBarangs
 * @property Perkiraan $perkiraan
 * @property Perusahaan $perusahaan
 * @property SatuanBarang $satuan
 * @property SalesStokGudang[] $salesStokGudangs
 */
class SalesMasterBarang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_master_barang}}';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_barang','id_satuan','jenis_barang_id','harga_beli', 'harga_jual'], 'required'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['kode_barang'],'unique'],
            [['id_perusahaan', 'is_hapus'], 'integer'],
            [['created'], 'safe'],
            [['nama_barang'], 'string', 'max' => 255],
            
            [['jenis_barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => MasterJenisBarang::className(), 'targetAttribute' => ['jenis_barang_id' => 'id']],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
         
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_barang' => 'Id Barang',
            'nama_barang' => 'Nama Barang',
            'harga_beli' => 'Harga Beli',
            'jenis_barang_id' => 'Jenis Barang',
            'harga_jual' => 'Harga Jual',
            'id_satuan' => 'Satuan',
            'created' => 'Created',
            'id_perusahaan' => 'Perusahaan',
            'is_hapus' => 'Is Hapus',
            // 'perkiraan_id' => 'Perkiraan ID',
            'kode_barang' => 'Kode Barang',
            'id_satuan' => 'Satuan'
        ];
    }

    public static function getLastKodeBarang($jenis){
        $query = SalesMasterBarang::find()->where(['like','kode_barang',$jenis]);
        $query->orderBy(['kode_barang'=>SORT_DESC]);
        $model = $query->one();
        
        if(empty($model))
            return false;

        return $model->kode_barang;
    } 

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $jenisBarang = MasterJenisBarang::findOne($this->jenis_barang_id);
        if(empty($jenisBarang))
            return false;


        $kode = SalesMasterBarang::getLastKodeBarang($jenisBarang->kode);
        $kode = substr($kode, -5);
        $kode = $kode + 1;
        
        $this->kode_barang = $jenisBarang->kode.\app\helpers\MyHelper::appendZeros($kode,5);

        return true;
    }

    public static function getListBarangs()
    {
       
        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['id_perusahaan' => $userPt]);
        }
        

        $listBarang=SalesMasterBarang::find()->where($where)->all();
        $listDataBarang=\yii\helpers\ArrayHelper::map($listBarang,'id_barang','nama_barang');

        return $listDataBarang;
    }

    public function afterFind(){
        parent::afterFind();

        $this->nama_barang = ucfirst(strtolower($this->nama_barang));
    }

    // public function getNamaSatuan()
    // {
    //     return $this->satuan->nama;
    // }

    public function getObatDetil()
    {
        return $this->hasOne(ObatDetil::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangDatangs()
    {
        return $this->hasMany(BarangDatang::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangHargas()
    {
        return $this->hasMany(BarangHarga::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangLosses()
    {
        return $this->hasMany(BarangLoss::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangRekaps()
    {
        return $this->hasMany(BarangRekap::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangStoks()
    {
        return $this->hasMany(BarangStok::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarangStokOpnames()
    {
        return $this->hasMany(BarangStokOpname::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBbmDispensers()
    {
        return $this->hasMany(BbmDispenser::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBbmFakturItems()
    {
        return $this->hasMany(BbmFakturItem::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBbmJuals()
    {
        return $this->hasMany(BbmJual::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenStoks()
    {
        return $this->hasMany(DepartemenStok::className(), ['barang_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequestOrderItems()
    {
        return $this->hasMany(RequestOrderItem::className(), ['item_id' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFakturBarang::className(), ['id_barang' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
 

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    public function getJenisBarang()
    {
        return $this->hasOne(MasterJenisBarang::className(), ['jenis_barang_id' => 'id']);
    }
   
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesStokGudangs()
    {
        return $this->hasMany(SalesStokGudang::className(), ['id_barang' => 'id_barang']);
    }

    public function getTotalStok()
    {
        $total = 0;

        $query = SalesStokGudang::find()->alias('t')->where([
            't.is_hapus'=>0,
            'id_barang' => $this->id_barang            
        ])->all();

        foreach($query as $item)
            $total += $item->jumlah;

        return $total;
    }
}
