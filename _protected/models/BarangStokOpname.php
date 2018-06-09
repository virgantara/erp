<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%barang_stok_opname}}".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $perusahaan_id
 * @property int $gudang_id
 * @property int $shift_id
 * @property double $stok
 * @property double $stok_lalu
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property string $created
 *
 * @property SalesMasterBarang $barang
 * @property SalesMasterGudang $gudang
 * @property Perusahaan $perusahaan
 * @property Shift $shift
 */
class BarangStokOpname extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_stok_opname}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\AttributeBehavior::className(),
                'attributes' => [
                    // update 1 attribute 'created' OR multiple attribute ['created','updated']
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['tanggal'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'tanggal',
                ],
                'value' => function ($event) {
                    return date('Y-m-d H:i:s', strtotime($this->tanggal));
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
            [['barang_id', 'perusahaan_id', 'gudang_id', 'shift_id', 'tanggal','jam'], 'required'],
            [['barang_id', 'perusahaan_id', 'gudang_id', 'shift_id', 'bulan', 'tahun'], 'integer'],
            [['stok', 'stok_lalu'], 'number'],
            [['tanggal', 'created'], 'safe'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['gudang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesGudang::className(), 'targetAttribute' => ['gudang_id' => 'id_gudang']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['shift_id' => 'id']],
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
            'perusahaan_id' => 'Perusahaan',
            'gudang_id' => 'Gudang',
            'shift_id' => 'Shift',
            'stok' => 'Stok (Liter)',
            'stok_lalu' => 'Stok Lalu',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal Ukur',
            'jam' => 'Jam Ukur',
            'created' => 'Created',
            'namaShift' => 'Shift',
            'namaPerusahan' => 'Perusahaan',
            'namaBarang' => 'Barang',
            'namaGudang' => 'Gudang'
        ];
    }

    public static function getStokOpname($tanggal, $barang_id)
    {

            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $query=BarangStokOpname::find()->where($where);
                
        $query->andFilterWhere([
            'tanggal'=> $tanggal,
            'barang_id' => $barang_id
        ]);

        $query->orderBy(['tanggal'=>'DESC']);
        $query->limit(1);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
    }

    public static function getStokLalu($bulan, $tahun, $barang_id)
    {

        $datestring=$tahun.'-'.$bulan.'-01 first day of last month';
        $dt=date_create($datestring);
        $lastMonth = $dt->format('m'); //2011-02
        $lastYear = $dt->format('Y');
        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $query=BarangStokOpname::find()->where($where);
        
        $query->andFilterWhere([
            'bulan'=> $lastMonth,
            'tahun'=> $lastYear,
            'barang_id' => $barang_id
        ]);

        $query->orderBy(['tanggal'=>'DESC']);
        $query->limit(1);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesBarang::className(), ['id_barang' => 'barang_id']);
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

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    public function getNamaPerusahaan()
    {
        return $this->perusahaan->nama;
    }

    public function getNamaGudang()
    {
        return $this->gudang->nama;
    }

}
