<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan_sub".
 *
 * @property int $id
 * @property string $nama
 * @property int $perusahaan_id
 * @property int $user_id
 * @property string $created
 *
 * @property Perusahaan $perusahaan
 * @property User $user
 * @property PerusahaanSubStok[] $perusahaanSubStoks
 */
class Departemen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%departemen}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'perusahaan_id'], 'required'],
            [['perusahaan_id'], 'integer'],
            [['created'], 'safe'],
            [['nama'], 'string', 'max' => 100],
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
            'nama' => 'Nama',
            'perusahaan_id' => 'Perusahaan',
            'created' => 'Created',
        ];
    }

    public function getDepartemenUsers()
    {
        return $this->hasMany(DepartemenUser::className(), ['departemen_id' => 'id']);
    }

    public static function getDepartemenId()
    {
        $userPt = '';
               
        $userLevel = Yii::$app->user->identity->access_role;    
            
        $query=DepartemenUser::find();
        if($userLevel != 'admin' && ($userLevel == 'operatorCabang' || $userLevel == 'operatorApotik')){
            $userPt = Yii::$app->user->identity->perusahaan_id;

            $query->where('user_id = :p1' ,[':p1'=>Yii::$app->user->id]);
            // $where = array_merge($where,['perusahaan_id' => $userPt]);   
            
        }

        $list=$query->one();

        return $list->id;
    }

    public static function getListDepartemens()
    {
        $userPt = '';
               
        $userLevel = Yii::$app->user->identity->access_role;    
            
        $query=Departemen::find();
        if($userLevel != 'admin' && $userLevel == 'operatorCabang'){
            $userPt = Yii::$app->user->identity->perusahaan_id;

            $query->where('perusahaan_id = :p2' ,[':p2'=>$userPt]);
            // $where = array_merge($where,['perusahaan_id' => $userPt]);   
            
        }

        $list=$query->all();
        $listData=\yii\helpers\ArrayHelper::map($list,'id','nama');
        return $listData;
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

    public function getNamaUser()
    {
        return $this->user->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenStoks()
    {
        return $this->hasMany(DepartemenStok::className(), ['perusahaan_sub_id' => 'id']);
    }
}
