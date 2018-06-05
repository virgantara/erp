<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departemen_jual".
 *
 * @property int $id
 * @property int $departemen_id
 * @property int $departemen_stok_id
 * @property double $jumlah
 * @property string $tanggal
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Departemen $departemen
 * @property Perusahaan $perusahaan
 * @property DepartemenStok $departemenStok
 */
class DepartemenJual extends \yii\db\ActiveRecord
{

   

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departemen_jual';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['departemen_stok_id', 'tanggal'], 'required'],
            [['departemen_stok_id', 'perusahaan_id'], 'integer'],
            [['jumlah'], 'number'],
            [['tanggal', 'created'], 'safe'],
            
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['departemen_stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => DepartemenStok::className(), 'targetAttribute' => ['departemen_stok_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'departemen_stok_id' => 'Departemen Stok ID',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

    public function getNamaBarang()
    {
        return $this->departemenStok->barang->nama_barang;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartemenStok()
    {
        return $this->hasOne(DepartemenStok::className(), ['id' => 'departemen_stok_id']);
    }
}
