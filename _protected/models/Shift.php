<?php

namespace app\models;

use Yii;

use yii\helpers\ArrayHelper;

use yii\data\ActiveDataProvider;
/**
 * This is the model class for table "shift".
 *
 * @property int $id
 * @property string $nama
 * @property string $jam_mulai
 * @property string $jam_selesai
 * @property int $perusahaan_id
 *
 * @property Perusahaan $perusahaan
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'jam_mulai', 'jam_selesai', 'perusahaan_id'], 'required'],
            [['jam_mulai', 'jam_selesai'], 'safe'],
            [['perusahaan_id'], 'integer'],
            [['nama'], 'string', 'max' => 50],
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
            'jam_mulai' => 'Jam Mulai',
            'jam_selesai' => 'Jam Selesai',
            'perusahaan_id' => 'Perusahaan ID',
        ];
    }

    public static function getDataProviderShifts()
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['perusahaan_id' => $userPt]);
        }


        $query=Shift::find()->where($where);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
     public static function getListShifts()
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,['perusahaan_id' => $userPt]);
        }


        $list=Shift::find()->where($where)->all();
        $list=ArrayHelper::map($list,'id','nama');

        return $list;
    }

    public function getNamaPerusahaan()
    {
        return $this->perusahaan->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
