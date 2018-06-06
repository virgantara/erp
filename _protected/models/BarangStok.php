<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang_stok".
 *
 * @property int $id
 * @property int $barang_id
 * @property double $stok
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property double $stok_bulan_lalu
 * @property double $tebus_liter
 * @property double $tebus_rupiah
 * @property double $dropping
 * @property double $sisa_do
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Perusahaan $perusahaan
 * @property SalesMasterBarang $barang
 */
class BarangStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_stok}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'stok', 'bulan', 'tahun', 'tanggal', 'perusahaan_id'], 'required'],
            [['barang_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['stok', 'stok_bulan_lalu', 'tebus_liter', 'tebus_rupiah', 'dropping', 'sisa_do','sisa_do_lalu'], 'number'],
            [['tanggal', 'created'], 'safe'],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
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
            'stok' => 'Stok',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal',
            'stok_bulan_lalu' => 'Stok Bulan Lalu',
            'tebus_liter' => 'Tebus Liter',
            'tebus_rupiah' => 'Tebus Rupiah',
            'dropping' => 'Dropping',
            'sisa_do' => 'Sisa DO',
            'sisa_do_lalu' => 'Sisa DO Lalu',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
        ];
    }

    public static function getStokBulanLalu($bulan, $tahun, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $query=BarangStok::find()->where($where);
        
        $query->andFilterWhere([
            'bulan'=> $bulan,
            'tahun'=> $tahun,
            'barang_id' => $barang_id
        ]);

        $query->orderBy(['tanggal'=>'DESC']);
        $query->limit(1);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
    }

    public static function getStokTanggal($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $where = array_merge($where,[self::tableName().'.barang_id' => $barang_id]);
        $query=BarangStok::find()->where($where);
        
        $query->andFilterWhere(['tanggal'=> $tanggal]);
        
        $query->orderBy(['tanggal'=>'ASC']);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
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
    public function getBarang()
    {
        return $this->hasOne(SalesBarang::className(), ['id_barang' => 'barang_id']);
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }
}
