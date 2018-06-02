<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sales_master_barang".
 *
 * @property int $id_barang
 * @property string $nama_barang
 * @property double $harga_beli
 * @property double $harga_jual
 * @property int $id_satuan
 * @property string $created
 * @property int $id_perusahaan
 * @property int $id_gudang
 *
 * @property SalesFakturBarang[] $salesFakturBarangs
 * @property Perusahaan $perusahaan
 * @property SalesMasterGudang $gudang
 * @property SalesSatuan $satuan
 * @property SalesStokGudang[] $salesStokGudangs
 */
class SalesBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_master_barang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_barang', 'harga_beli', 'harga_jual', 'id_satuan', 'id_perusahaan'], 'required'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['id_satuan', 'id_perusahaan'], 'integer'],
            [['created','is_hapus'], 'safe'],
            [['nama_barang'], 'string', 'max' => 255],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
            [['id_satuan'], 'exist', 'skipOnError' => true, 'targetClass' => SatuanBarang::className(), 'targetAttribute' => ['id_satuan' => 'id_satuan']],
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
            'harga_jual' => 'Harga Jual',
            'id_satuan' => 'Satuan',
            'created' => 'Created',
            'id_perusahaan' => 'Perusahaan',
            
          
            'is_hapus'  => 'Is Hapus'
        ];
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
        

        $listBarang=SalesBarang::find()->where($where)->all();
        $listDataBarang=ArrayHelper::map($listBarang,'id_barang','nama_barang');

        return $listDataBarang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFaktur::className(), ['id_barang' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

  
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSatuan()
    {
        return $this->hasOne(SatuanBarang::className(), ['id_satuan' => 'id_satuan']);
    }

    public function getNamaSatuan()
    {
        return $this->satuan->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesStokGudangs()
    {
        return $this->hasMany(SalesStokGudang::className(), ['id_barang' => 'id_barang']);
    }

    public function getBarangHargas() 
    { 
        return $this->hasMany(BarangHarga::className(), ['barang_id' => 'id_barang']); 
    } 
}