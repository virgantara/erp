<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kas".
 *
 * @property int $id
 * @property string $kwitansi
 * @property string $penanggung_jawab
 * @property string $keterangan
 * @property string $tanggal
 * @property int $jenis_kas
 * @property double $kas_keluar
 * @property double $kas_masuk
 * @property string $created
 */
class Kas extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kas';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'kwitansi', // required
                // 'group' => $this->id_branch, // optional
                'value' => 'KW.'.date('Y-m-d').'.?' , // format auto number. '?' will be replaced with generated number
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
            [['penanggung_jawab', 'keterangan', 'tanggal','perkiraan_id'], 'required'],
            [['keterangan','kode_transaksi'], 'string'],
            [['tanggal', 'created','kas_besar_kecil','kode_transaksi'], 'safe'],
            [['jenis_kas'], 'integer'],
            [['kas_keluar', 'kas_masuk'], 'number'],
            [['kwitansi'], 'string', 'max' => 50],
            [['kwitansi'], 'autonumber', 'format'=>'KW.'.date('Y-m-d').'.?'],
            [['penanggung_jawab'], 'string', 'max' => 255],
            [['perkiraan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perkiraan::className(), 'targetAttribute' => ['perkiraan_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kwitansi' => 'Kwitansi',
            'penanggung_jawab' => 'Penanggung Jawab',
            'perkiraan_id' => 'Perkiraan',
            'keterangan' => 'Keterangan',
            'tanggal' => 'Tanggal',
            'jenis_kas' => 'Jenis Kas',
            'kas_keluar' => 'Kas Keluar',
            'kas_masuk' => 'Kas Masuk',
            'saldo' => 'Saldo',
            'kas_besar_kecil' => 'Ukuran Kas',
            'created' => 'Created',
            'kode_transaksi' => 'Kode Transaksi'
        ];
    }

    public static function updateSaldo($uk,$bulan, $tahun)
    {
        
        
        $y = $tahun;
        $m = $bulan;
        $sd = $y.'-'.$m.'-01';
        $ed = $y.'-'.$m.'-'.date('t');
        
       

        $saldo_awal = 0;
        $session = Yii::$app->session;
        $userPt = '';
        $where = ['between','tanggal',$sd,$ed];
        $userLevel = Yii::$app->user->identity->access_role;    
            
        if($userLevel != 'admin'){
            $userPt = Yii::$app->user->identity->perusahaan_id;
        }


        $whereSaldo = ['bulan' => $bulan,'tahun'=>$tahun,'perusahaan_id'=>$userPt,'jenis' => $uk];
        $saldo = Saldo::find()->where($whereSaldo)->one();
        
        if(!empty($saldo))
        {
            $saldo_awal = $saldo->nilai_awal;               
        }

        $kas = Kas::find()->where($where)->andWhere(['perusahaan_id'=>$userPt,'kas_besar_kecil'=>$uk])->orderBy(['tanggal'=>'ASC'])->all();
        

        $tmp_saldo = $saldo_awal;
        
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try 
        {
            foreach($kas as $k)
            {
                if($k->jenis_kas == 1)
                    $tmp_saldo = $tmp_saldo + $k->kas_masuk;
                else
                    $tmp_saldo = $tmp_saldo - $k->kas_keluar;  
                
                $k->saldo = $tmp_saldo;
                $k->save();
            }

            $nextMonth = date('Y-m-d', strtotime('+1 month',strtotime($sd)));
            $y = date("Y",strtotime($nextMonth));
            $m = date("m",strtotime($nextMonth));

            $whereSaldo = ['bulan' => $m,'tahun'=>$y,'perusahaan_id'=>$userPt,'jenis' => $uk];
            $tmp = Saldo::find()->where($whereSaldo)->one();
            if(empty($tmp))
            {
                $saldo = new Saldo;
                $saldo->nilai_awal = $tmp_saldo;
                $saldo->nilai_akhir = 0;
                $saldo->bulan = $m;
                $saldo->tahun = $y;
                $saldo->jenis = $uk;
                $saldo->perusahaan_id = $userPt;
                $saldo->save();
            }

            else{
                $tmp->nilai_awal = $tmp_saldo;
                $tmp->save();

                $saldo->nilai_akhir = $tmp_saldo;
                $saldo->save();
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerkiraan()
    {
        return $this->hasOne(Perkiraan::className(), ['kode' => 'perkiraan_id']);
    }

    public static function getTotal($provider, $columnName)
    {
        $total = 0;
        foreach ($provider as $item) {
          $total += $item[$columnName];
      }
      return number_format($total,2,',','.');  
    }

   
}
