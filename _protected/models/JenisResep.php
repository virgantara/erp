<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%jenis_resep}}".
 *
 * @property int $id
 * @property string $nama
 * @property int $perusahaan_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Perusahaan $perusahaan
 */
class JenisResep extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%jenis_resep}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nama', 'perusahaan_id'], 'required'],
            [['id', 'perusahaan_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 255],
            [['id'], 'unique'],
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
            'perusahaan_id' => 'Perusahaan ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

    public static function getListJenisReseps()
    {    
        $userPt = Yii::$app->user->identity->perusahaan_id;
        $query = JenisResep::find();
        $query->where('perusahaan_id = :p1' ,[':p1'=>$userPt]);
        

        $list=$query->all();
        $listData=\yii\helpers\ArrayHelper::map($list,'id','nama');
        return $listData;
    }
}
