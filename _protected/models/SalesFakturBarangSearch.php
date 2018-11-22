<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesFakturBarang;

/**
 * SalesFakturBarangSearch represents the model behind the search form of `app\models\SalesFakturBarang`.
 */
class SalesFakturBarangSearch extends SalesFakturBarang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_faktur_barang', 'id_faktur', 'id_barang', 'jumlah', 'id_satuan'], 'integer'],
            [['created'], 'safe'],
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
        $query = SalesFakturBarang::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_faktur_barang' => $this->id_faktur_barang,
            'id_faktur' => $this->id_faktur,
            'id_barang' => $this->id_barang,
            'jumlah' => $this->jumlah,
            'id_satuan' => $this->id_satuan,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
