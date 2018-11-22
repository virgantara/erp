<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "{{%barang_datang}}".
 *
 * @property int $id
 * @property string $tanggal
 * @property double $jumlah
 * @property int $shift_id
 * @property int $perusahaan_id
 * @property string $created
 * @property int $barang_id
 *
 * @property SalesMasterBarang $barang
 * @property Perusahaan $perusahaan
 * @property Shift $shift
 */
class BarangDatang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_datang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggal', 'shift_id', 'perusahaan_id', 'barang_id','jam','jumlah'], 'required'],
            [['tanggal', 'created','jam'], 'safe'],
            [['jumlah'], 'number'],
            [['shift_id', 'perusahaan_id', 'barang_id'], 'integer'],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['shift_id' => 'id']],
        ];
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
                    return date('Y-m-d', strtotime($this->tanggal));
                },
            ],
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
            'jumlah' => 'Jumlah',
            'shift_id' => 'Shift ID',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
            'barang_id' => 'Barang ID',
            'jam'=>'Jam Datang'
        ];
    }

    public static function getBarangDatang($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $where = array_merge($where,['barang_id' => $barang_id]);
        $query=self::find()->where($where);
        
        $query->andFilterWhere(['tanggal'=> $tanggal]);
        
        $query->orderBy(['tanggal'=>'ASC']);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
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

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }

    public function getNamaShift()
    {
        return $this->shift->nama;
    }

    public function getNamaPerusahaan()
    {
        return $this->perusahaan->nama;
    }
}
