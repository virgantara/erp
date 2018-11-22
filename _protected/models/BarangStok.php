<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "barang_stok".
 *
 * @property int $id
 * @property int $barang_id
 * @property double $stok
 * @property int $bulan
 * @property int $tahun
 * @property string $tanggal
 * @property double $stok_bulan_lalu
 * @property double $tebus_liter
 * @property double $tebus_rupiah
 * @property double $dropping
 * @property double $sisa_do
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Perusahaan $perusahaan
 * @property SalesMasterBarang $barang
 */
class BarangStok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%barang_stok}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'stok', 'bulan', 'tahun', 'tanggal', 'perusahaan_id'], 'required'],
            [['barang_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['stok', 'stok_bulan_lalu', 'tebus_liter', 'tebus_rupiah', 'dropping', 'sisa_do','sisa_do_lalu'], 'number'],
            [['tanggal', 'created'], 'safe'],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['barang_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalesMasterBarang::className(), 'targetAttribute' => ['barang_id' => 'id_barang']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'barang_id' => 'Barang ID',
            'stok' => 'Stok',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'tanggal' => 'Tanggal',
            'stok_bulan_lalu' => 'Stok Bulan Lalu',
            'tebus_liter' => 'Tebus Liter',
            'tebus_rupiah' => 'Tebus Rupiah',
            'dropping' => 'Dropping',
            'sisa_do' => 'Sisa DO',
            'sisa_do_lalu' => 'Sisa DO Lalu',
            'perusahaan_id' => 'Perusahaan ID',
            'created' => 'Created',
        ];
    }

    public static function hitungLoss($bulan, $tahun, $barang_id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try 
        {
            $barang = \app\models\SalesMasterBarang::findOne($barang_id);
            $datestring=$tahun.'-'.$bulan.'-01 first day of last month';
            $dt=date_create($datestring);
            $lastMonth = $dt->format('m'); //2011-02
            $lastYear = $dt->format('Y');
            $stokLalu = 0;
            $stokBulanLalu = BarangStok::getStokBulanLalu($lastMonth, $lastYear, $barang_id);
            $stokLalu = !empty($stokBulanLalu) ? $stokBulanLalu->stok : 0;
            $stokOpname = \app\models\BarangStokOpname::getStokOpname($tahun.'-'.$bulan.'-01', $barang_id);

            $stokLaluReal = !empty($stokOpname) ? $stokOpname->stok : $stokLalu;
            $givendate = $tahun.'-'.$bulan.'-01';
            $tgl_akhir = date('t',strtotime($givendate));
            for($i = 1;$i<=$tgl_akhir;$i++)
            {


                $tgl = str_pad($i, 2, '0', STR_PAD_LEFT);
                $fulldate = $tahun.'-'.$bulan.'-'.$tgl;
                $barangRekap = \app\models\BarangRekap::find()->where([
                    'tanggal' => $fulldate,
                    'barang_id' => $barang_id,
                    'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
                ])->one();

                if(empty($barangRekap))
                    $barangRekap = new \app\models\BarangRekap;

                $m = BarangStok::getStokTanggal($fulldate, $barang_id);
                $mjual = \app\models\BbmJual::getJualTanggal($fulldate, $barang_id);
                $dropping = \app\models\BarangDatang::getBarangDatang($fulldate, $barang_id);

                $stokOpname = \app\models\BarangStokOpname::getStokOpname($fulldate, $barang_id);
                $stokOpnameValue = !empty($stokOpname) ? $stokOpname->stok : 0;
                $saldoJual = 0;

                $harga = $barang->harga_jual;

                foreach ($mjual as $mj) {
                    $saldoJual += ($mj->stok_akhir - $mj->stok_awal);
                    $harga = $mj->harga;
                }

                

                if($tgl=='01')
                {
                    $stokLalu = $stokLalu == 0 ? 1 : $stokLalu;
                    $nilai_loss = $stokOpnameValue > 0 ? ($stokLalu - $stokOpnameValue) / $stokLalu : 0;
                    $barangRekap->is_loss = 1;
                    $barangRekap->loss = $nilai_loss;
                    BarangStok::updateLoss($fulldate, $barang_id, $stokLalu, $stokLaluReal, $nilai_loss, $barang);
                    
                }

                $stok_bulan_lalu = !empty($m) ? $m->stok_bulan_lalu : 0;
                $jml_dropping = !empty($dropping) ? $dropping->jumlah : 0;
                $stokLalu = $stokLalu + $jml_dropping - $saldoJual;
                $stokLaluReal = $stokLaluReal + $jml_dropping - $saldoJual;
                
                $sisa_do_lalu = !empty($m) ? $m->sisa_do_lalu : 0;
                $tebus_liter = !empty($m) ? $m->tebus_liter : 0;
                $sisa_do = $sisa_do_lalu + $tebus_liter - $jml_dropping;
                $sisa_do = $sisa_do >= 0 ? $sisa_do : 0;

                if(!empty($stokOpname) && $tgl != '01')
                {
                    $stokLalu = $stokLalu == 0 ? 1 : $stokLalu;
                    $stokLaluReal = $stokOpnameValue;
                    $nilai_loss = $stokOpnameValue > 0 ? ($stokLalu - $stokOpnameValue) / $stokLalu : 0;
                    $barangRekap->is_loss = 1;
                    $barangRekap->loss = $nilai_loss;
                    BarangStok::updateLoss($fulldate, $barang_id, $stokLalu, $stokLaluReal, $nilai_loss, $barang);
                }

                if($tgl == $tgl_akhir)
                    BarangStok::updateStok($fulldate, $barang, $stokLaluReal);

                // $stokLalu = $stokLaluReal;

                $barangRekap->tebus_liter = !empty($m) ? $m->tebus_liter : 0;
                $barangRekap->tebus_rupiah = !empty($m) ? $m->tebus_rupiah : 0;
                $barangRekap->dropping = !empty($dropping) ? $jml_dropping :  0;
                $barangRekap->sisa_do = $sisa_do;
                $barangRekap->jual_liter = $saldoJual;
                $barangRekap->jual_rupiah = $saldoJual * $harga;
                $barangRekap->stok_adm = $stokLalu;
                $barangRekap->stok_riil = $stokLaluReal;
               
                $barangRekap->tanggal = $fulldate;
                $barangRekap->barang_id = $barang_id;
                $barangRekap->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
                $barangRekap->save();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public static function updateLoss($fulldate, $barang_id, $stokLalu, $stokLaluReal, $nilai_loss, $barang)
    {

        $bulan = date('m',strtotime($fulldate));
        $tahun = date('Y',strtotime($fulldate));
        $barangLoss = \app\models\BarangLoss::find()->where([
            'tanggal' => $fulldate,
            'barang_id' => $barang_id,
            'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
        ])->one();

        if(empty($barangLoss))
            $barangLoss = new \app\models\BarangLoss;
        
        $barangLoss->barang_id = $barang_id;
        $barangLoss->bulan = date('m',strtotime($fulldate));
        $barangLoss->tahun = date('Y',strtotime($fulldate));
        $barangLoss->tanggal = $fulldate;
        $barangLoss->jam = date('H:i:s');
        $barangLoss->stok_adm = $stokLalu;
        $barangLoss->stok_riil = $stokLaluReal;
        $barangLoss->loss = $nilai_loss;
        $barangLoss->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
        $barangLoss->save();
        $kode_transaksi = $barangLoss->kode_transaksi;
        
        $tgl_akhir = $tahun.'-'.$bulan.'-'.date('t',strtotime($fulldate));
        if($fulldate == $tgl_akhir)
        {

            $userPt = Yii::$app->user->identity->perusahaan_id;
            $kas = \app\models\Kas::find()->where(['kode_transaksi'=>$kode_transaksi])->one();
            if(empty($kas))
                $kas = new \app\models\Kas;    

            $perkiraan = \app\models\Perkiraan::find()->where([
                'kode' => '5101',
                'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
            ])->one();

            $kas->kas_keluar = ($stokLalu - $stokLaluReal) * $barang->harga_beli;
            $kas->perkiraan_id = $perkiraan->id;
            $kas->perusahaan_id = $userPt;
            $kas->penanggung_jawab = Yii::$app->user->identity->username;
            $uk = 'besar';
            $kas->keterangan = $perkiraan->nama.' '.$barang->nama_barang.' Tgl '.Yii::$app->formatter->asDate($fulldate);
            $kas->tanggal = $fulldate;
            $kas->jenis_kas = 0; // kas keluar    
            $kas->perusahaan_id = $userPt;
            $kas->kas_besar_kecil = $uk;
            $kas->kode_transaksi = $kode_transaksi;

            $kas->save();
            
           
            \app\models\Kas::updateSaldo($uk,$bulan,$tahun);

            
        }
    }

    public static function updateStok($tanggal, $barang, $jumlah)
    {
        $tgl = $tanggal;
        $tahun = date("Y",strtotime($tgl));
        $bulan = date("m",strtotime($tgl));

        $datestring=$tgl.' first day of last month';
        $dt=date_create($datestring);
        $lastMonth = $dt->format('m'); //2011-02
        $lastYear = $dt->format('Y');

        
        $stokLalu = BarangStok::getStokBulanLalu($lastMonth, $lastYear, $barang->id_barang);

        if(!empty($stokLalu))
        {
            $stok = BarangStok::find()->where([
                'barang_id' => $barang->id_barang,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
            ])->one();

            if(empty($stok))
                $stok = new BarangStok;
            
            $stok->barang_id = $barang->id_barang;
            $stok->stok = $jumlah;
            $stok->stok_bulan_lalu = !empty($stokLalu) ? $stokLalu->stok : 0;
            $stok->sisa_do_lalu = !empty($stokLalu) ? $stokLalu->sisa_do : 0;
            $stok->tebus_liter = 0;
            $stok->tebus_rupiah = 0;
            $stok->bulan = $bulan;
            $stok->tahun = $tahun;
            $stok->tanggal = $tgl;
            $stok->perusahaan_id = Yii::$app->user->identity->perusahaan_id;
            $stok->save();
        }
    }

    public static function getStokBulanLalu($bulan, $tahun, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $query=BarangStok::find()->where($where);
        
        $query->andFilterWhere([
            'bulan'=> $bulan,
            'tahun'=> $tahun,
            'barang_id' => $barang_id
        ]);

        $query->orderBy(['tanggal'=>'DESC']);
        $query->limit(1);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
    }

    public static function getStokTanggal($tanggal, $barang_id)
    {

        $userPt = '';
            
        $where = [];    
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
            $where = array_merge($where,[self::tableName().'.perusahaan_id' => $userPt]);
        }

        $where = array_merge($where,[self::tableName().'.barang_id' => $barang_id]);
        $query=BarangStok::find()->where($where);
        
        $query->andFilterWhere(['tanggal'=> $tanggal]);
        
        $query->orderBy(['tanggal'=>'ASC']);

        
        // $list=ArrayHelper::map($list,'shift_id','shift.nama');

        return $query->one();
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerusahaan()
    {
        return $this->hasOne(Perusahaan::className(), ['id_perusahaan' => 'perusahaan_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }

    public function getNamaBarang()
    {
        return $this->barang->nama_barang;
    }
}
