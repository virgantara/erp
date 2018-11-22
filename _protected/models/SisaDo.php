<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "erp_sisa_do".
 *
 * @property int $id
 * @property int $barang_id
 * @property int $perusahaan_id
 * @property string $tanggal
 * @property string $created
 * @property double $jumlah
 */
class SisaDo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'erp_sisa_do';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['barang_id', 'perusahaan_id', 'tanggal'], 'required'],
            [['barang_id', 'perusahaan_id'], 'integer'],
            [['tanggal', 'created'], 'safe'],
            [['jumlah'], 'number'],
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
            'perusahaan_id' => 'Perusahaan ID',
            'tanggal' => 'Tanggal',
            'created' => 'Created',
            'jumlah' => 'Jumlah',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->tanggal = date('Y-m-d',strtotime($this->tanggal));
        // $this->tanggal_tempo = date('Y-m-d',strtotime($this->tanggal_tempo));
        return true;
    }

    public function afterFind(){
        parent::afterFind();

        $this->tanggal = date('d-M-Y',strtotime($this->tanggal));
    }

    public static function getSisaDo($bulan, $tahun, $barang_id){
        $prevDate = date('Y-m-d',strtotime($tahun.'-'.$bulan.'-01 -1 month'));
        $query = SisaDo::find()->where([
            'barang_id' => $barang_id,
        ]);

        $lastDate = date('Y-m-d',strtotime(date('t').'-'.$bulan.'-'.$tahun.' -1 month'));
        $query->andWhere(['between','tanggal',$prevDate,$lastDate]);

        $total = 0;
        foreach($query->all() as $item)
            $total += $item->jumlah;

        return $total;
    }  
}
