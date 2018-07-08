<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan_sub_stok".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $perusahaan_sub_id
 * @property double $stok_akhir
 * @property double $stok_awal
 * @property string $created
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property double $stok_bulan_lalu
 * @property double $stok
 * @property int $ro_item_id
 *
 * @property SalesMasterBarang $barang
 * @property RequestOrderItem $roItem
 * @property PerusahaanSub $perusahaanSub
 */
class DepartemenStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%departemen_stok}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'departemen_id', 'tanggal'], 'required'],
            [['barang_id', 'departemen_id', 'bulan', 'tahun', 'ro_item_id'], 'integer'],
            [['stok_akhir', 'stok_awal', 'stok_bulan_lalu', 'stok'], 'number'],
            [['created', 'tanggal'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['ro_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrderItem::className(), 'targetAttribute' => ['ro_item_id' => 'id']],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
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
            'departemen_id' => 'Departemen',
            'stok_akhir' => 'Stok Akhir',
            'stok_awal' => 'Stok Awal',
            'created' => 'Created',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal',
            'stok_bulan_lalu' => 'Stok Bulan Lalu',
            'stok' => 'Qty',
            'ro_item_id' => 'Ro Item ID',
        ];
    }

    public static function getListStokDepartemen()
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        $list_user = [
            'operatorCabang'
        ];

        if(in_array($userLevel, $list_user)){
            $userPt = Yii::$app->user->identity->id;
            $where = array_merge($where,['d.user_id' => $userPt]);
        }

        $query = DepartemenStok::find();
        $query->joinWith(['departemen as d']);
        $query->andFilterWhere($where);

        $list = $query->all();

        $listDataGudang=ArrayHelper::map($list,'id','d.nama');
        return $listDataGudang;
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    public function getNamaDepartemen()
    {
        return $this->departemen->nama;   
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
    public function getRoItem()
    {
        return $this->hasOne(RequestOrderItem::className(), ['id' => 'ro_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemen()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id']);
    }
}
