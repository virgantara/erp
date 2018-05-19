<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_faktur".
 *
 * @property int $id_faktur
 * @property int $id_suplier
 * @property string $no_faktur
 * @property string $created
 * @property string $tanggal_faktur
 * @property int $id_perusahaan
 *
 * @property Perusahaan $perusahaan
 * @property SalesFakturBarang[] $salesFakturBarangs
 */
class SalesFaktur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales_faktur';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_suplier', 'no_faktur', 'tanggal_faktur', 'id_perusahaan'], 'required'],
            [['id_suplier', 'id_perusahaan'], 'integer'],
            [['created', 'tanggal_faktur'], 'safe'],
            [['no_faktur'], 'string', 'max' => 50],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_faktur' => 'Id Faktur',
            'id_suplier' => 'Id Suplier',
            'no_faktur' => 'No Faktur',
            'created' => 'Created',
            'tanggal_faktur' => 'Tanggal Faktur',
            'id_perusahaan' => 'Id Perusahaan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFakturBarang::className(), ['id_faktur' => 'id_faktur']);
    }
}
