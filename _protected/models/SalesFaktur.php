<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sales_faktur".
 *
 * @property int $id_faktur
 * @property int $id_suplier
 * @property string $no_faktur
 * @property string $created
 * @property string $tanggal_faktur
 * @property int $id_perusahaan
 *
 * @property Perusahaan $perusahaan
 * @property SalesSuplier $suplier
 * @property SalesFakturBarang[] $salesFakturBarangs
 */
class SalesFaktur extends \yii\db\ActiveRecord
{

    public $tanggal_awal;
    public $tanggal_akhir;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sales_faktur}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_suplier', 'tanggal_faktur', 'id_perusahaan','tanggal_jatuh_tempo', 'tanggal_dropping'], 'required'],
            [['id_suplier', 'id_perusahaan'], 'integer'],
            [['created', 'tanggal_faktur'], 'safe'],
            [['no_faktur'], 'string', 'max' => 50],
            [['id_perusahaan'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['id_perusahaan' => 'id_perusahaan']],
            [['id_suplier'], 'exist', 'skipOnError' => true, 'targetClass' => SalesSuplier::className(), 'targetAttribute' => ['id_suplier' => 'id_suplier']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_faktur' => 'Faktur',
            'id_suplier' => 'Suplier',
            'no_faktur' => 'No Faktur',
            'created' => 'Created',
            'tanggal_faktur' => 'Tgl Faktur',
            'id_perusahaan' => 'Perusahaan',
            'tanggal_jatuh_tempo' => 'Tgl Jatuh Tempo',
            'tanggal_dropping' => 'Tgl Dropping',
            'is_approved' => 'Approval',
            'no_so' => 'No SO',
            'no_do' => 'No DO'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'id_perusahaan']);
    }

    public function getNamaSuplier()
    {
      return $this->suplier->nama;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuplier()
    {
        return $this->hasOne(SalesSuplier::className(), ['id_suplier' => 'id_suplier']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSalesFakturBarangs()
    {
        return $this->hasMany(SalesFakturBarang::className(), ['id_faktur' => 'id_faktur']);
    }

    public static function getTotal($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
          $total += $item[$columnName];
      }
      return number_format($total,2,',','.');  
    }

    // public static function getSubtotal($provider)
    // {
    //   $total = 0;

    //   foreach ($provider as $item) {
    //     $subtotal = $item['harga_beli'] * $item['jumlah'];
        
    //   }
    //   return number_format($total,2,',','.');  
    // }

    public static function getTotalSubtotalFormatted($provider)
    {
      $total = 0;

      foreach ($provider as $item) {
        $subtotal = $item->harga_beli * $item->jumlah;
        $total += $subtotal;
      }

      
      return number_format($total,2,',','.'); 


    }

    public static function getTotalSubtotal($provider)
    {
      $total = 0;

      foreach ($provider as $item) {
        $subtotal = $item->harga_beli * $item->jumlah;
        $total += $subtotal;
      }


      return $total;  


    }
}
