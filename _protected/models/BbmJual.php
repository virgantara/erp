<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;

use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "bbm_jual".
 *
 * @property int $id
 * @property string $tanggal
 * @property int $barang_id
 * @property string $created
 * @property int $perusahaan_id
 * @property int $shift_id
 * @property int $dispenser_id
 * @property double $stok_awal
 * @property double $stok_akhir
 *
 * @property Shift $shift
 * @property SalesMasterBarang $barang
 * @property BbmDispenser $dispenser
 * @property Perusahaan $perusahaan
 */
class BbmJual extends \yii\db\ActiveRecord
{
    public $saldoBbm;

    public $itemExist;

    public function getSaldoBbm()
    {
        $this->saldoBbm = 0;

        if (is_numeric($this->stok_akhir) && is_numeric($this->stok_akhir)) {
            $this->saldoBbm = $this->stok_akhir - $this->stok_akhir;
        }

        return $this->saldoBbm;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bbm_jual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'barang_id', 'perusahaan_id', 'shift_id', 'dispenser_id', 'stok_awal', 'stok_akhir'], 'required'],
            [['tanggal', 'created','saldoBbm','harga'], 'safe'],
            [['barang_id'],'validateItemExist'],
            [['barang_id', 'perusahaan_id', 'shift_id', 'dispenser_id'], 'integer'],
            [['stok_awal', 'stok_akhir'], 'number'],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['shift_id' => 'id']],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['dispenser_id'], 'exist', 'skipOnError' => true, 'targetClass' => BbmDispenser::className(), 'targetAttribute' => ['dispenser_id' => 'id']],
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
            'tanggal' => 'Tanggal',
            'barang_id' => 'Barang ID',
            'created' => 'Created',
            'perusahaan_id' => 'Perusahaan ID',
            'shift_id' => 'Shift ID',
            'dispenser_id' => 'Dispenser ID',
            'stok_awal' => 'Stok Awal',
            'stok_akhir' => 'Stok Akhir',
            'saldoBbm' => 'Saldo',
            'harga'=>'Harga'
        ];
    }

    public function validateItemExist($attribute, $params)
    {
        $tmp = BbmJual::find()->where([
            'tanggal' => $this->tanggal,
            'shift_id' => $this->shift_id,
            'dispenser_id' => $this->dispenser_id,
            'perusahaan_id' => $this->perusahaan_id
        ])->one();

        if(!empty($tmp)){
            $this->addError($attribute, 'Data ini sudah diinputkan');
        }
        
    }

    public static function getListJualTanggal($bulan, $tahun, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $y = $tahun;
        $m = $bulan;
        $sd = $y.'-'.$m.'-01';
        $ed = $y.'-'.$m.'-'.date('t');
        $where = array_merge($where,[self::tableName().'.barang_id' => $barang_id]);
        $query=BbmJual::find()->where($where);
        
        $query->andFilterWhere(['between', 'tanggal', $sd, $ed]);
        $query->groupBy(['tanggal']);
        $query->orderBy(['tanggal'=>'ASC']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $dataProvider;
    }

    public static function getListJualShifts($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $where = array_merge($where,[self::tableName().'.tanggal' => $tanggal]);


        $query=BbmJual::find()->where($where);
        $query->andWhere(['barang_id'=>$barang_id]);
        $query->joinWith(['shift as shift']);
        
        $query->groupBy(['shift_id']);
      
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id' => 'shift_id']);
    }

    public function getNamaShift()
    {
        return $this->shift->nama;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispenser()
    {
        return $this->hasOne(BbmDispenser::className(), ['id' => 'dispenser_id']);
    }

    public function getNamaDispenser()
    {
        return $this->dispenser->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

     public function getNamaPerusahaan()
    {
        return $this->perusahaan->nama;
    }

}
