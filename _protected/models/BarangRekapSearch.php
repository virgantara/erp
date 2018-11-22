<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangRekap;

/**
 * BarangRekapSearch represents the model behind the search form of `app\models\BarangRekap`.
 */
class BarangRekapSearch extends BarangRekap
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'perusahaan_id'], 'integer'],
            [['tebus_liter', 'tebus_rupiah', 'dropping', 'sisa_do', 'jual_liter', 'jual_rupiah', 'stok_adm', 'stok_riil', 'loss'], 'number'],
            [['tanggal', 'created'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($bulan, $tahun, $barang_id)
    {
        $query = BarangRekap::find();


        $y = $tahun;
        $m = $bulan;
        $sd = $y.'-'.$m.'-01';
        $ed = $y.'-'.$m.'-'.date('t',strtotime($sd));
        $query->where([
            'barang_id'=>$barang_id,
            // 'tanggal'=>$tanggal,
            'perusahaan_id' => Yii::$app->user->identity->perusahaan_id
        ]);
        $query->andFilterWhere(['between', 'tanggal', $sd, $ed]);

        return $query->all();
    }
}
