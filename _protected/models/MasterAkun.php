<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "master_akun".
 *
 * @property string $kode_akun
 * @property string $uraian_akun
 */
class MasterAkun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_akun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_akun', 'uraian_akun'], 'required'],
            [['kode_akun'], 'string', 'max' => 8],
            [['uraian_akun'], 'string', 'max' => 50],
            [['uraian_akun'], 'unique'],
            [['kode_akun'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'kode_akun' => 'Kode Akun',
            'uraian_akun' => 'Uraian Akun',
        ];
    }
}
