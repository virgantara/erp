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
        return 'departemen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'perusahaan_id', 'user_id'], 'required'],
            [['perusahaan_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['nama'], 'string', 'max' => 100],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User',
            'created' => 'Created',
        ];
    }

    public static function getListDepartemens()
    {
        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin' && $userLevel == 'operatorCabang'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['perusahaan_id' => $userPt,'user_id' => Yii::$app->user->id]);
            
        }

        $list=Departemen::find()->where($where)->all();
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
