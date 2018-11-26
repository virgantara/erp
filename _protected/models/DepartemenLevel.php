<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%departemen_level}}".
 *
 * @property int $id
 * @property string $nama
 * @property int $level
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Departemen[] $departemens
 */
class DepartemenLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%departemen_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'level'], 'required'],
            [['level'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nama'], 'string', 'max' => 100],
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
            'level' => 'Level',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemens()
    {
        return $this->hasMany(Departemen::className(), ['departemen_level_id' => 'id']);
    }
}
