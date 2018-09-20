<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "request_order".
 *
 * @property int $id
 * @property string $no_ro
 * @property int $petugas1
 * @property int $petugas2
 * @property string $tanggal_pengajuan
 * @property string $tanggal_penyetujuan
 * @property int $perusahaan_id
 * @property string $created
 *
 * @property Perusahaan $perusahaan
 * @property RequestOrderItem[] $requestOrderItems
 */
class RequestOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%request_order}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'no_ro', // required
                // 'group' => $this->id_branch, // optional
                'value' => 'RO.'.date('Y-m-d').'.?' , // format auto number. '?' will be replaced with generated number
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
            [['tanggal_pengajuan', 'perusahaan_id','departemen_id'], 'required'],
            [['perusahaan_id','departemen_id'], 'integer'],
            [['tanggal_pengajuan', 'tanggal_penyetujuan', 'created','is_approved','is_approved_by_kepala'], 'safe'],
            [['no_ro'], 'string', 'max' => 100],
            [['no_ro'], 'autonumber', 'format'=>'RO.'.date('Y-m-d').'.?'],
            [['departemen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id' => 'id']],
             [['departemen_id_to'], 'exist', 'skipOnError' => true, 'targetClass' => Departemen::className(), 'targetAttribute' => ['departemen_id_to' => 'id']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no_ro' => 'No Ro',
            'petugas1' => 'Petugas 1',
            'petugas2' => 'Petugas 2',
            'tanggal_pengajuan' => 'Tgl Pengajuan',
            'tanggal_penyetujuan' => 'Tgl Penyetujuan',
            'perusahaan_id' => 'Perusahaan',
            'created' => 'Created',
            'is_approved' => 'Disetujui',
            'departemen_id' => 'Departemen',
            'departemen_id_to' => 'RO ke ',
            'namaDeptTujuan' => 'Dept Tujuan',
            'namaDeptAsal' => 'Unit Pemohon',
            'is_approved_by_kepala' => 'Is Approved by Kepala'
        ];
    }


    // public static function updateStok($id_ro)
    // {
    //     $ro = \app\models\RequestOrder::findOne($id_ro);

    //     if($ro->is_approved == 1)
    //     {

    //         foreach($ro->requestOrderItems as $item)
    //         {
    //             $stok_id = $item->stok_id;
    //             $jumlah = $item->jumlah_beri;
    //             echo $stok_id.'<br>';
    //             $gudang = \app\models\SalesStokGudang::findOne($stok_id);
    //             $gudang->jumlah = $item->jumlah_beri;
    //             $gudang->save();
    //         }

    //         exit;
    //     }
    // }

    public function getNamaDeptAsal()
    {
        return $this->departemen->nama;
    }

    public function getNamaDeptTujuan()
    {
        return $this->departemenTo->nama;
    }


    public function getDepartemen() 
    { 
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id']); 
    }

    public function getDepartemenTo() 
    { 
        return $this->hasOne(Departemen::className(), ['id' => 'departemen_id_to']); 
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
    public function getRequestOrderItems()
    {
        return $this->hasMany(RequestOrderItem::className(), ['ro_id' => 'id']);
    }
}
