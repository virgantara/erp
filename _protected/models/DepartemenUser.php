<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%departemen_user}}".
 *
 * @property int $id
 * @property int $departemen_id
 * @property int $user_id
 * @property string $created
 *
 * @property Departemen $departemen
 * @property User $user
 */
class DepartemenUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%departemen_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departemen_id', 'user_id'], 'required'],
            [['departemen_id', 'user_id'], 'integer'],
            [['created'], 'safe'],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departemen_id' => 'Departemen ID',
            'user_id' => 'User ID',
            'created' => 'Created',
        ];
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
