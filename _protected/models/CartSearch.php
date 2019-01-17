<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cart;

/**
 * CartSearch represents the model behind the search form of `app\models\Cart`.
 */
class CartSearch extends Cart
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departemen_stok_id', 'jumlah_hari', 'signa1', 'signa2'], 'integer'],
            [['kode_transaksi', 'kode_racikan', 'created_at', 'updated_at'], 'safe'],
            [['qty', 'kekuatan', 'dosis_minta', 'subtotal', 'jumlah_ke_apotik'], 'number'],
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
        $query = Cart::find();

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
            'id' => $this->id,
            'departemen_stok_id' => $this->departemen_stok_id,
            'qty' => $this->qty,
            'kekuatan' => $this->kekuatan,
            'dosis_minta' => $this->dosis_minta,
            'subtotal' => $this->subtotal,
            'jumlah_ke_apotik' => $this->jumlah_ke_apotik,
            'jumlah_hari' => $this->jumlah_hari,
            'signa1' => $this->signa1,
            'signa2' => $this->signa2,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'kode_transaksi', $this->kode_transaksi])
            ->andFilterWhere(['like', 'kode_racikan', $this->kode_racikan]);

        return $dataProvider;
    }
}
