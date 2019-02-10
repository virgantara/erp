<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%penjualan}}".
 *
 * @property int $id
 * @property string $kode_penjualan
 * @property string $kode_daftar
 * @property string $tanggal
 * @property int $departemen_id
 * @property int $customer_id
 * @property int $is_approved
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Departemen $departemen
 * @property PenjualanItem[] $penjualanItems
 * @property PenjualanResep[] $penjualanReseps
 */
class Penjualan extends \yii\db\ActiveRecord
{
   
    public $tanggal_awal;
    public $tanggal_akhir;
    public $jenisRawat;
    public $unitRawat;
    public $jenisResep;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%penjualan}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kode_penjualan', // required
                'value' => date('Ymd').'?' , // format auto number. '?' will be replaced with generated number
                'digit' => 4 // optional, default to null. 
            ],
        ];
    }

   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_penjualan', 'tanggal', 'departemen_id', 'customer_id','kode_transaksi'], 'required'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
            [['kode_transaksi'], 'unique'],
            [['departemen_id', 'customer_id'], 'integer'],
            [['kode_penjualan', 'kode_daftar'], 'string', 'max' => 20],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
            [['kode_penjualan'], 'autonumber', 'format'=>date('Ymd').'?'],
        ];
    }

    public function beforeSave($insert){
      if(!parent::beforeSave($insert)){
        return false;
      }

      if($this->isNewRecord)
        $this->kode_penjualan = Yii::$app->user->identity->departemenKode.$this->jenisRawat.$this->kode_penjualan;
      
      return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_penjualan' => 'Kode Penjualan',
            'kode_daftar' => 'Kode Daftar',
            'tanggal' => 'Tanggal',
            'departemen_id' => 'Departemen ID',
            'customer_id' => 'Customer ID',
          
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'kode_transaksi' => 'Kode Trx',
            'status_penjualan' => 'Status',
            'namaPasien' => 'Nama Px',
            'RMPasien' => 'No RM',
        ];
    }

    public function getJenisPasien()
    {
        return $this->penjualanResep->pasien_jenis;
    }

    public function getNamaUnit()
    {
        return $this->departemen->nama;
    }

    public function getNamaPasien()
    {
        return $this->penjualanResep->pasien_nama;
    }

    public function getRMPasien()
    {
        return $this->penjualanResep->pasien_id;
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
    public function getPenjualanItems()
    {
        return $this->hasMany(PenjualanItem::className(), ['penjualan_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPenjualanResep()
    {
        return $this->hasOne(PenjualanResep::className(), ['penjualan_id' => 'id']);
    }

    public static function getTotalSubtotal($provider)
    {
      $total = 0;

      foreach ($provider->penjualanItems as $item) {
        $total += $item->subtotal;
      }


      return $total;  
    }

    public static function getTotalKeapotek($provider)
    {
      $total = 0;

      foreach ($provider->penjualanItems as $item) {
        $h = $item->jumlah_ke_apotik * $item->harga;
        $total += $h;
      }


      return $total;  
    }
}
