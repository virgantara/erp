<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_suplier".
 *
 * @property int $id_suplier
 * @property string $nama
 * @property string $alamat
 * @property string $telp
 * @property string $email
 * @property int $id_perusahaan
 * @property string $created
 */
class SalesSuplier extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sales_suplier';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'alamat', 'telp', 'id_perusahaan'], 'required'],
            [['id_perusahaan'], 'integer'],
            [['created'], 'safe'],
            [['nama', 'alamat', 'telp', 'email'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_suplier' => 'Id Suplier',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'telp' => 'Telp',
            'email' => 'Email',
            'id_perusahaan' => 'Perusahaan',
            'created' => 'Created',
        ];
    }
}
