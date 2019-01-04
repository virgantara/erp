<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tr_rawat_inap_alkes}}".
 *
 * @property int $id_ri_alkes
 * @property int $id_alkes
 * @property double $biaya_ird
 * @property double $biaya_irna
 * @property int $jumlah_tindakan
 * @property string $created
 * @property int $id_rawat_inap
 *
 * @property TrRawatInap $rawatInap
 * @property ObatAlkes $alkes
 */
class RawatInapAlkes extends SimrsModel
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tr_rawat_inap_alkes}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alkes', 'biaya_ird', 'biaya_irna', 'jumlah_tindakan', 'id_rawat_inap'], 'required'],
            [['id_alkes', 'jumlah_tindakan', 'id_rawat_inap'], 'integer'],
            [['biaya_ird', 'biaya_irna'], 'number'],
            [['created'], 'safe'],
            [['id_rawat_inap'], 'exist', 'skipOnError' => true, 'targetClass' => TrRawatInap::className(), 'targetAttribute' => ['id_rawat_inap' => 'id_rawat_inap']],
            [['id_alkes'], 'exist', 'skipOnError' => true, 'targetClass' => ObatAlkes::className(), 'targetAttribute' => ['id_alkes' => 'id_obat_alkes']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ri_alkes' => 'Id Ri Alkes',
            'id_alkes' => 'Id Alkes',
            'biaya_ird' => 'Biaya Ird',
            'biaya_irna' => 'Biaya Irna',
            'jumlah_tindakan' => 'Jumlah Tindakan',
            'created' => 'Created',
            'id_rawat_inap' => 'Id Rawat Inap',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRawatInap()
    {
        return $this->hasOne(TrRawatInap::className(), ['id_rawat_inap' => 'id_rawat_inap']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlkes()
    {
        return $this->hasOne(ObatAlkes::className(), ['id_obat_alkes' => 'id_alkes']);
    }
}
