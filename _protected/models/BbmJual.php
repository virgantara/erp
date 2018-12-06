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
        return '{{%bbm_jual}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kode_transaksi', // required
                // 'group' => $this->id_branch, // optional
                'value' => 'TRJ.'.date('Y-m-d').'.?' , // format auto number. '?' will be replaced with generated number
                'digit' => 4 // optional, default to null. 
            ],
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['tanggal'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal',
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime($this->tanggal));
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'barang_id', 'perusahaan_id', 'shift_id', 'dispenser_id', 'stok_awal', 'stok_akhir'], 'required'],
            [['tanggal', 'created','saldoBbm','harga','kode_transaksi','no_nota'], 'safe'],
            [['barang_id'],'validateItemExist'],
            [['barang_id', 'perusahaan_id', 'shift_id', 'dispenser_id'], 'integer'],
            [['stok_awal', 'stok_akhir'], 'number'],
            [['kode_transaksi'], 'autonumber', 'format'=>'TRJ.'.date('Y-m-d').'.?'],
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
            // 'tanggal_tempo' => 'Tanggal Jatuh Tempo',
            'barang_id' => 'Barang ID',
            'created' => 'Created',
            'perusahaan_id' => 'Perusahaan ID',
            'shift_id' => 'Shift ID',
            'dispenser_id' => 'Dispenser ID',
            'stok_awal' => 'Stok Awal',
            'stok_akhir' => 'Stok Akhir',
            'saldoBbm' => 'Saldo',
            'harga'=>'Harga',
            'kode_transaksi' => 'Kode Transaksi',
            // 'is_piutang' => 'Piutang',
            'no_nota' => 'Nota'
        ];
    }



    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $barang = \app\models\SalesMasterBarang::findOne($this->barang_id);
        $this->harga = $barang->harga_jual;
        // $this->tanggal_tempo = date('Y-m-d',strtotime($this->tanggal_tempo));
        return true;
    }

    public function validateItemExist($attribute, $params)
    {

        $barang = \app\models\SalesMasterBarang::findOne($this->barang_id);
        $tmp = BbmJual::find()->where([
            'tanggal' => date('Y-m-d', strtotime($this->tanggal)),
            'harga'=>$barang->harga_jual,
            'dispenser_id' => $this->dispenser_id,
            'shift_id' => $this->shift_id,
            'perusahaan_id' => $this->perusahaan_id
        ])->one();
        if(!empty($tmp)){
            $this->addError($attribute, 'Data ini sudah diinputkan');
        }
        
    }

    public static function getItemJual($tanggal, $barang_id, $shift_id, $dispenser_id)
    {

        $userPt = '';
            
        // $where = [];    
        // $userLevel = Yii::$app->user->identity->access_role;    
            
        // if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
        //     $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        // }

        // $where = array_merge($where,[self::tableName().'.tanggal' => $tanggal]);


        $query=BbmJual::find();
        $query->where(['tanggal'=>$tanggal,'barang_id'=>$barang_id,'shift_id'=>$shift_id,'dispenser_id'=>$dispenser_id,'perusahaan_id'=>$userPt]);
        // $query->joinWith(['shift as shift']);
        
      
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->all();
    }

    public function hitungDispenser($tanggal, $barang_id, $shift_id)
    {

   
        $query=BbmJual::find();
        
        $query->andFilterWhere([
            'barang_id' => $barang_id,
            'tanggal'=> $tanggal,
            'shift_id' => $shift_id,
            'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
        ]);

        
        $query->orderBy(['tanggal'=>'ASC']);

        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->count();
    }

    public static function getListMultiJual($tanggal, $barang_id, $shift_id, $disp_id)
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
        $query->andWhere(['barang_id'=>$barang_id,'shift_id'=>$shift_id]);
        $query->joinWith(['shift as shift']);
        // $query->groupBy(['shift_id']);
      
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->all();
    }


    public static function getJualTanggal($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $where = array_merge($where,[self::tableName().'.barang_id' => $barang_id]);
        $query=BbmJual::find()->where($where);
        
        $query->andFilterWhere(['tanggal'=> $tanggal]);
        
        $query->orderBy(['tanggal'=>'ASC']);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->all();
    }

    public static function getListJualPerTanggal($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        // $y = $tahun;
        // $m = $bulan;
        // $sd = $y.'-'.$m.'-01';
        // $ed = $y.'-'.$m.'-'.date('t');
        $where = array_merge($where,[self::tableName().'.barang_id' => $barang_id]);
        $query=BbmJual::find()->where($where);
        
        $query->andFilterWhere(['tanggal', $tanggal]);
        // $query->groupBy(['tanggal']);
        $query->orderBy(['tanggal'=>'ASC']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $dataProvider;
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
        // $query->groupBy(['tanggal']);
        $query->orderBy(['tanggal'=>SORT_ASC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $dataProvider;
    }

    public static function getListJualPerShift($tanggal, $barang_id, $shift_id)
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
        $query->andWhere(['barang_id'=>$barang_id,'shift_id'=>$shift_id]);
        $query->joinWith(['shift as shift']);
        // $query->groupBy(['shift_id']);
      
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->all();
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
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
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
