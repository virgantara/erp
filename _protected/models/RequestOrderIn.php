<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%request_order_in}}".
 *
 * @property int $id
 * @property int $perusahaan_id
 * @property int $departemen_id
 * @property int $ro_id
 * @property string $created
 *
 * @property RequestOrder $ro
 * @property Departemen $departemen
 * @property Perusahaan $perusahaan
 */
class RequestOrderIn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request_order_in}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['perusahaan_id', 'departemen_id', 'ro_id'], 'required'],
            [['perusahaan_id', 'departemen_id', 'ro_id'], 'integer'],
            [['created'], 'safe'],
            [['ro_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestOrder::className(), 'targetAttribute' => ['ro_id' => 'id']],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
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
            'perusahaan_id' => 'Perusahaan ID',
            'departemen_id' => 'Departemen ID',
            'ro_id' => 'Ro ID',
            'created' => 'Created',
        ];
    }

    public function getNamaSender()
    {
        return $this->ro->departemen->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRo()
    {
        return $this->hasOne(RequestOrder::className(), ['id' => 'ro_id']);
    }

    public function getNoRo()
    {
        return $this->ro->no_ro;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemen()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }
}
