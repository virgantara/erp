<?php

namespace app\models;

use Yii;



use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sales_stok_gudang".
 *
 * @property int $id_stok
 * @property int $id_gudang
 * @property int $id_barang
 * @property double $jumlah
 * @property string $created
 *
 * @property SalesIncome[] $salesIncomes
 * @property SalesMasterBarang $barang
 * @property SalesMasterGudang $gudang
 */
class SalesStokGudang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_stok_gudang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gudang', 'id_barang', 'jumlah'], 'required'],
            [['id_gudang', 'id_barang'], 'integer'],
            [['jumlah'], 'number'],
            [['created','is_hapus'], 'safe'],
            [['id_barang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['id_barang' => 'id_barang']],
            [['id_gudang'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['id_gudang' => 'id_gudang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_stok' => 'Id Stok',
            'id_gudang' => 'Gudang',
            'id_barang' => 'Barang',
            'jumlah' => 'Jumlah',
            'created' => 'Created',
            'is_hapus' => 'Is Hapus',
            'exp_date' => 'Exp Date',
            'batch_no' => 'Batch No.',
            'faktur_barang_id' => 'FB ID'
        ];
    }

     public function afterFind(){
        parent::afterFind();

        $this->exp_date = date('d-M-Y',strtotime($this->exp_date));
    }


    public static function getListStokGudang()
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        $list_user = [
            'adminSpbu','gudang','admSalesCab','operatorCabang'
        ];

        if(in_array($userLevel, $list_user)){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['id_perusahaan' => $userPt]);
        }

        $query = SalesStokGudang::find()->where([self::tableName().'.is_hapus'=>0]);
        $query->joinWith(['gudang as gd']);
        $query->andWhere(['gd.id_perusahaan'=>$userPt]);
        $query->groupBy(['id_gudang']);

        $list = $query->all();

        $listDataGudang=ArrayHelper::map($list,'id_stok','gudang.nama');
        return $listDataGudang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesIncomes()
    {
        return $this->hasMany(SalesIncome::className(), ['stok_id' => 'id_stok']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'id_barang']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGudang()
    {
        return $this->hasOne(SalesGudang::className(), ['id_gudang' => 'id_gudang']);
    }

    public function getNamaGudang()
    {
        return $this->gudang->nama;
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    public function getKodeBarang()
    {
        return $this->barang->kode_barang;
    }

    public function getDurasiExp(){
        return $this->exp_date;
    }

    public function getJumlahStok()
    {
        $total = 0;

        $query = SalesStokGudang::find()->where([
            self::tableName().'.is_hapus'=>0,
            'id_barang' => $this->id_barang            
        ])->all();

        foreach($query as $item)
            $total += $item->jumlah;

        return $total;
    }
}
