<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "perusahaan_level".
 *
 * @property int $id
 * @property string $nama
 * @property int $level
 */
class PerusahaanLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'perusahaan_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'level'], 'required'],
            [['level'], 'integer'],
            [['nama'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'level' => 'Level',
        ];
    }
}
