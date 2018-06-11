<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%durasi_tempo}}".
 *
 * @property int $id
 * @property string $nama
 * @property int $durasi
 */
class DurasiTempo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%durasi_tempo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['durasi'], 'integer'],
            [['nama'], 'string', 'max' => 20],
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
            'durasi' => 'Durasi',
        ];
    }
}
