<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_margin".
 *
 * @property int $id
 * @property double $batas_bawah
 * @property double $batas_atas
 * @property double $persentase
 */
class Margin extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_margin';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batas_bawah', 'batas_atas', 'persentase'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batas_bawah' => 'Batas Bawah',
            'batas_atas' => 'Batas Atas',
            'persentase' => 'Persentase',
        ];
    }

    public static function getMargin($hb){

        $result = Margin::find()
        ->where(['>=' , 'batas_atas',$hb])
        ->andWhere(['<=' ,'batas_bawah',$hb])->one();


        return $result->persentase / 100 * $hb;
    }
}
