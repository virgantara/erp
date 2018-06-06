<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bbm_faktur".
 *
 * @property int $id
 * @property int $suplier_id
 * @property string $no_lo
 * @property string $tanggal_lo
 * @property string $no_so
 * @property string $tanggal_so
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Perusahaan $perusahaan
 * @property SalesSuplier $suplier
 * @property BbmFakturItem[] $bbmFakturItems
 */
class BbmFaktur extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%bbm_faktur}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suplier_id', 'perusahaan_id'], 'required'],
            [['suplier_id', 'perusahaan_id'], 'integer'],
            [['tanggal_lo', 'tanggal_so', 'created','is_selesai'], 'safe'],
            [['no_lo', 'no_so'], 'string', 'max' => 100],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['suplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesSuplier::className(), 'targetAttribute' => ['suplier_id' => 'id_suplier']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'suplier_id' => 'Suplier',
            'no_lo' => 'No LO',
            'tanggal_lo' => 'Tanggal LO',
            'no_so' => 'No SO',
            'tanggal_so' => 'Tanggal SO',
            'perusahaan_id' => 'Perusahaan',
            'is_selesai' => 'Selesai',
            'created' => 'Created',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->tanggal_so = date('Y-m-d', strtotime($this->tanggal_so));
        if(!empty($this->tanggal_lo))
            $this->tanggal_lo = date('Y-m-d', strtotime($this->tanggal_lo));

        return true;
    }

    // public function behaviors()
    // {
    //     return [
    //         [
    //             'class' => \yii\behaviors\AttributeBehavior::className(),
    //             'attributes' => [
    //                 // update 1 attribute 'created' OR multiple attribute ['created','updated']
    //                 \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['tanggal_so','tanggal_lo'],
    //                 \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['tanggal_so','tanggal_lo'],
    //             ],
               
    //             'value' => function ($event) {
    //                 print_r($event->name);exit;
    //                 $this->tanggal_so = date('Y-m-d', strtotime($this->tanggal_so));
    //                 $this->tanggal_lo = date('Y-m-d', strtotime($this->tanggal_lo));
    //                 return true;
    //             },
    //         ],
    //     ];
    // }

    public function getVolume()
    {
        return $this->hasMany(BbmFakturItem::className(), ['faktur_id' => 'id'])->sum('jumlah');
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
    public function getSuplier()
    {
        return $this->hasOne(SalesSuplier::className(), ['id_suplier' => 'suplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBbmFakturItems()
    {
        return $this->hasMany(BbmFakturItem::className(), ['faktur_id' => 'id']);
    }

    public function getNamaSuplier()
    {
        return $this->suplier->nama;
    }

}
