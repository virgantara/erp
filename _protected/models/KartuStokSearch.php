<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\KartuStok;

/**
 * KartuStokSearch represents the model behind the search form of `app\models\KartuStok`.
 */
class KartuStokSearch extends KartuStok
{
    // public $tanggal_awal;
    // public $tanggal_akhir;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'departemen_id', 'stok_id'], 'integer'],
            [['qty_in','qty_out'], 'number'],
            [['keterangan', 'created_at', 'updated_at','tanggal'], 'safe'],
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
    public function search($params)
    {
        $query = KartuStok::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params);
        $this->barang_id = $params['KartuStok']['barang_id'];
        $this->tanggal_awal = date('Y-m-d',strtotime($params['KartuStok']['tanggal_awal']));
        $this->tanggal_akhir = date('Y-m-d',strtotime($params['KartuStok']['tanggal_akhir']));
        if(!empty($params))
        {

            $query->where(['barang_id'=>$this->barang_id]);
            $query->andFilterWhere(['between', 'tanggal', $this->tanggal_awal, $this->tanggal_akhir]);
        }

        return $dataProvider;
    }

    public function searchByTanggal($tanggal, $barang_id)
    {
        $query = KartuStok::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $query->where(['barang_id'=>$barang_id]);
        $query->andWhere(['tanggal'=> $tanggal]);
        

        return $dataProvider;
    }

}
