<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "sales_master_gudang".
 *
 * @property int $id_gudang
 * @property string $nama
 * @property string $alamat
 * @property string $telp
 * @property int $id_perusahaan
 *
 * @property SalesMasterBarang[] $salesMasterBarangs
 * @property Perusahaan $perusahaan
 * @property SalesStokGudang[] $salesStokGudangs
 */
class SalesGudang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_master_gudang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'telp','kapasitas','is_sejenis'], 'required'],
            [['id_perusahaan'], 'integer'],
            [['kapasitas'],'number'],
            [['nama', 'alamat', 'telp'], 'string', 'max' => 255],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_gudang' => 'Id Gudang',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'id_perusahaan' => 'Perusahaan',
            'kapasitas' => 'Kapasitas',
            'is_sejenis' => 'Satu Jenis Barang',
             'is_hapus'  => 'Is Hapus',
             'is_penuh'=> 'Penuh'
             
        ];
    }

    public static function getListGudangs($isNewRecord=0)
    {
        $userPt = '';
            
        $where = [
            'is_hapus' => 0,
        ];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['id_perusahaan' => $userPt]);
        }

        $whereGudang = $where;
        if($isNewRecord==1)
            $whereGudang = array_merge($where,['is_penuh'=>0]);

        $listGudang=SalesGudang::find()->where($whereGudang)->all();
        $listDataGudang=ArrayHelper::map($listGudang,'id_gudang','nama');

        return $listDataGudang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesMasterBarangs()
    {
        return $this->hasMany(SalesMasterBarang::className(), ['id_gudang' => 'id_gudang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    public function getSalesStokGudangs()
    {
        return $this->hasMany(SalesStokGudang::className(), ['id_gudang' => 'id_gudang']);
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getSalesGudangs()
    // {
    //     return $this->hasMany(SalesGudang::className(), ['id_gudang' => 'id_gudang']);
    // }
}
