<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%master_jenis_barang}}".
 *
 * @property int $id
 * @property string $kode
 * @property string $nama
 * @property int $perusahaan_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Perusahaan $perusahaan
 * @property SalesMasterBarang[] $salesMasterBarangs
 */
class MasterJenisBarang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%master_jenis_barang}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode', 'nama', 'perusahaan_id'], 'required'],
            [['perusahaan_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['kode'], 'string', 'max' => 4],
            [['nama'], 'string', 'max' => 255],
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
            'kode' => 'Kode',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesMasterBarangs()
    {
        return $this->hasMany(SalesMasterBarang::className(), ['jenis_barang_id' => 'id']);
    }

    public static function getList()
    {

        $query=MasterJenisBarang::find();

        $userLevel = Yii::$app->user->identity->access_role;    
        
        if($userLevel != 'theCreator'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $query->where(['perusahaan_id'=>$userPt]);
        }

        $list = $query->all();
        $list=\yii\helpers\ArrayHelper::map($list,'id','nama');

        return $list;
    }
}
