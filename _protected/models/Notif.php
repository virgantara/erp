<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%notif}}".
 *
 * @property int $id
 * @property string $keterangan
 * @property int $departemen_from_id
 * @property int $departemen_to_id
 * @property int $is_read_from
 * @property int $is_read_to
 * @property int $is_hapus
 * @property string $created
 * @property int $item_id
 *
 * @property Departemen $departemenFrom
 * @property Departemen $departemenTo
 */
class Notif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notif}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['keterangan', 'departemen_from_id', 'departemen_to_id'], 'required'],
            [['departemen_from_id', 'departemen_to_id', 'is_read_from', 'is_read_to', 'is_hapus', 'item_id'], 'integer'],
            [['created'], 'safe'],
            [['keterangan'], 'string', 'max' => 255],
            [['departemen_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_from_id' => 'id']],
            [['departemen_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_to_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keterangan' => 'Keterangan',
            'departemen_from_id' => 'Departemen From ID',
            'departemen_to_id' => 'Departemen To ID',
            'is_read_from' => 'Is Read From',
            'is_read_to' => 'Is Read To',
            'is_hapus' => 'Is Hapus',
            'created' => 'Created',
            'item_id' => 'Item ID',
            'namaDepartemenFrom' => 'From',
            'namaDepartemenTo' => 'To',
        ];
    }

    public static function listNotif()
    {
        $total = 0;
        $du = DepartemenUser::find()->where(['user_id'=>Yii::$app->user->identity->id])->one();
        if(!empty($du)){
            $notif = Notif::find();
            $notif->where('departemen_to_id = :p1 AND is_read_to = 0',[':p1'=>$du->departemen_id]);
            $total = count($notif->all());
        }
        return $total;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenFrom()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_from_id']);
    }

    public function getNamaDepartemenFrom(){
        return $this->departemenFrom->nama;
    }

    public function getNamaDepartemenTo(){
        return $this->departemenTo->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenTo()
    {
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_to_id']);
    }
}
