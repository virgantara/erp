<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesIncome;

/**
 * SalesIncomeSearch represents the model behind the search form of `app\models\SalesIncome`.
 */
class SalesIncomeSearch extends SalesIncome
{

    public $namaGudang;
    public $namaBarang;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_sales', 'stok_id', 'id_perusahaan'], 'integer'],
            [['jumlah', 'harga'], 'number'],
            [['tanggal', 'created','namaGudang','namaBarang'], 'safe'],
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
        $query = SalesIncome::find();
        $query->joinWith(['stok','stok.gudang','stok.barang']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['sales_master_barang.nama_barang'=>SORT_ASC],
            'desc' => ['sales_master_barang.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaGudang'] = [
            'asc' => ['sales_master_gudang.nama'=>SORT_ASC],
            'desc' => ['sales_master_gudang.nama'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'id_sales' => $this->id_sales,
            'stok_id' => $this->stok_id,
            'jumlah' => $this->jumlah,
            'harga' => $this->harga,
            'tanggal' => $this->tanggal,
            'created' => $this->created,
            'id_perusahaan' => $this->id_perusahaan,
        ]);

         $query->andFilterWhere(['like', 'sales_master_barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'sales_income.jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'sales_master_gudang.nama', $this->namaGudang]);

        return $dataProvider;
    }
}
