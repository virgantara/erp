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
            [['keterangan'], 'string'],
            [['tanggal', 'created','kas_besar_kecil'], 'safe'],
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
        if($session->isActive)
        {
            $userLevel = $session->get('level');    
            
            if($userLevel == 'admin'){
                $userPt = $session->get('perusahaan');

                // print_r($where);exit;    
            }

        }

        $whereSaldo = ['bulan' => $bulan,'tahun'=>$tahun,'perusahaan_id'=>$userPt,'jenis' => $uk];
        $saldo = Saldo::find()->where($whereSaldo)->one();
        
        if(!empty($saldo))
        {
            $saldo_awal = $saldo->nilai_awal;               
        }

        $kas = Kas::find()->where($where)->andWhere(['perusahaan_id'=>$userPt,'kas_besar_kecil'=>$uk])->orderBy(['tanggal'=>'ASC'])->all();
        
        // print_r($saldo_awal);exit;
        // else
        // {
        //     $saldo = Saldo::find()->where(['jenis' => 'besar','bulan'=>$bulan,'tahun'=>$tahun])->one();

        //     if(!empty($saldo))
        //     {
        //         $saldo_awal = $saldo->nilai_awal;
                
        //     }
        // }

        $saldo = $saldo_awal;
        foreach($kas as $k)
        {
            if($k->jenis_kas == 1)
                $saldo = $saldo + $k->kas_masuk;
            else
                $saldo = $saldo - $k->kas_keluar;  
            
            $k->saldo = $saldo;
            $k->save();

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
