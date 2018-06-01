<?php

namespace app\models;

use Yii;


use yii\helpers\ArrayHelper;

use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "bbm_dispenser".
 *
 * @property int $id
 * @property string $nama
 * @property int $perusahaan_id
 * @property int $barang_id
 *
 * @property SalesMasterBarang $barang
 * @property BbmJual[] $bbmJuals
 */
class BbmDispenser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bbm_dispenser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'perusahaan_id', 'barang_id'], 'required'],
            [['perusahaan_id', 'barang_id'], 'integer'],
            [['nama'], 'string', 'max' => 100],
             [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'perusahaan_id' => 'Perusahaan ID',
            'barang_id' => 'Barang ID',
        ];
    }

    public static function getDataProviderDispensers($barang_id='')
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['perusahaan_id' => $userPt]);
        }

        if(!empty($barang_id))
        {
             $where = array_merge($where,['barang_id' => $barang_id]);
        }

        $query=BbmDispenser::find()->where($where);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }

    public static function getListDispensers($barang_id='')
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['perusahaan_id' => $userPt]);
        }

        if(!empty($barang_id))
        {
             $where = array_merge($where,['barang_id' => $barang_id]);
        }

        $list=BbmDispenser::find()->where($where)->all();
        $list=ArrayHelper::map($list,'id','nama');

        return $list;
    }

    public function getPerusahaan() 
    { 
       return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']); 
    } 

    public function getNamaPerusahaan()
    {
        return $this->perusahaan->nama;
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
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
    public function getBbmJuals()
    {
        return $this->hasMany(BbmJual::className(), ['dispenser_id' => 'id']);
    }
}
