<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%kartu_stok}}".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $departemen_id
 * @property int $stok_id
 * @property double $qty
 * @property int $status_disposisi 0 = masuk, 1 = keluar
 * @property string $keterangan
 * @property string $created_at
 * @property string $updated_at
 *
 * @property SalesMasterBarang $barang
 * @property Departemen $departemen
 */
class KartuStok extends \yii\db\ActiveRecord
{

    public $tanggal_awal;
    public $tanggal_akhir;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kartu_stok}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'tanggal'], 'required'],
            [['barang_id', 'departemen_id', 'stok_id'], 'integer'],
            [['qty_in','qty_out'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['keterangan'], 'string', 'max' => 255],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
            // [['stok_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesStokGudang::className(), 'targetAttribute' => ['stok_id' => 'id_stok']],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang',
            'kode_transaksi' => 'Kode Trx',
            'departemen_id' => 'Departemen',
            'stok_id' => 'Stok',
            'qty_in' => 'Masuk',
            'qty_out' => 'Keluar',
            'tanggal_awal' => 'Tgl Awal',
            'tanggal_akhir' => 'Tgl Akhir',
            'keterangan' => 'Keterangan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // public function getStokBarang()
    // {
    //     return $this->hasOne(SalesStokGudang::className(), ['id_stok' => 'stok_id']);
    // }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    public static function deleteKartuStok($kode_transaksi){
        $m = KartuStok::find()->where(['kode_transaksi'=>$kode_transaksi]);
        foreach($m->all() as $item)
            $item->delete();
    }

    public static function getPrevStok($params)
    {
        $query = KartuStok::find();
        $query->where([
            'barang_id' => $params['barang_id'],
            'departemen_id' => $params['departemen_id'],
        ]);
        $query->orderBy(['created_at'=>SORT_DESC]);
        $query->limit(2);
        return $query->all();
    }

    public static function updateKartuStok($params){
        $m = KartuStok::find()->where([
            'barang_id' => $params['barang_id'],
            'departemen_id' => $params['departemen_id'],
            'kode_transaksi' => $params['kode_transaksi'] 
        ])->one();

        $prevStok = KartuStok::getPrevStok($params);

        if(!empty($m)){
        
            $m->barang_id = $params['barang_id'];
            if($params['status'] == 1){
                $m->qty_in = ceil($params['qty']);
                
            }
            else{
                $m->qty_out = ceil($params['qty']);

            }

            $m->kode_transaksi = !empty($params['kode_transaksi']) ? $params['kode_transaksi'] : '-';
            $m->tanggal = $params['tanggal'];
            $m->departemen_id = $params['departemen_id'];
            $m->stok_id = $params['stok_id'];
            $m->keterangan = $params['keterangan'];

            if(count($prevStok) > 1)
            {
                $m->prev_id = $prevStok[1]->id;
                $m->sisa_lalu = $prevStok[1]->sisa;
            }

            
            if($m->validate())
                $m->save();
            else{
                $errors = '';
                foreach($m->getErrors() as $attribute){
                    foreach($attribute as $error){
                        $errors .= $error.' ';
                    }
                }
                    
                print_r($errors);exit;             
            }
        }

        
    }

    public static function createKartuStok($params){
        $m = new KartuStok;


        $m->barang_id = $params['barang_id'];
        if($params['status'] == 1){
            $m->qty_in = ceil($params['qty']);
            
        }
        else{
            $m->qty_out = ceil($params['qty']);
           
        }

        $m->kode_transaksi = !empty($params['kode_transaksi']) ? $params['kode_transaksi'] : '-';
        $m->tanggal = $params['tanggal'];
        $m->departemen_id = $params['departemen_id'];
        $m->stok_id = $params['stok_id'];
        $m->keterangan = $params['keterangan'];
        if($m->validate())
            $m->save();
        else{
            $errors = '';
            foreach($m->getErrors() as $attribute){
                foreach($attribute as $error){
                    $errors .= $error.' ';
                }
            }
                
            print_r($errors);exit;             
        }
    }

    public static function getQty($provider, $inout=1)
    {
      $total = 0;

      foreach ($provider as $item) {
        
        switch ($inout) {
            case 1:
                $total += $item->qty_in;
                break;
            case 0:
                $total += $item->qty_out;
                break;
            
        }
        
        // $total += $subtotal;
      }


      return $total;  
    }

}
