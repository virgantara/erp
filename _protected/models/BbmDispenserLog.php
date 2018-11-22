<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_bbm_dispenser_log".
 *
 * @property int $id
 * @property int $dispenser_id
 * @property int $shift_id
 * @property int $perusahaan_id
 * @property double $jumlah
 * @property string $tanggal
 * @property string $created
 *
 * @property BbmDispenser $dispenser
 * @property Perusahaan $perusahaan
 * @property Shift $shift
 */
class BbmDispenserLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_bbm_dispenser_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dispenser_id', 'shift_id', 'perusahaan_id', 'tanggal'], 'required'],
            [['dispenser_id', 'shift_id', 'perusahaan_id'], 'integer'],
            [['jumlah'], 'number'],
            [['tanggal', 'created'], 'safe'],
            [['dispenser_id'], 'exist', 'skipOnError' => true, 'targetClass' => BbmDispenser::className(), 'targetAttribute' => ['dispenser_id' => 'id']],
            [['perusahaan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perusahaan::className(), 'targetAttribute' => ['perusahaan_id' => 'id_perusahaan']],
            [['shift_id'], 'exist', 'skipOnError' => true, 'targetClass' => Shift::className(), 'targetAttribute' => ['shift_id' => 'id']],
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
            'dispenser_id' => 'Dispenser ID',
            'shift_id' => 'Shift ID',
            'perusahaan_id' => 'Perusahaan ID',
            'jumlah' => 'Jumlah',
            'tanggal' => 'Tanggal',
            'created' => 'Created',
        ];
    }
    public function getBarang()
    {
        return $this->hasOne(SalesMasterBarang::className(), ['id_barang' => 'barang_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDispenser()
    {
        return $this->hasOne(BbmDispenser::className(), ['id' => 'dispenser_id']);
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
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id' => 'shift_id']);
    }
}
