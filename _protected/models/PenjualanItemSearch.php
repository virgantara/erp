<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanItem;

/**
 * PenjualanItemSearch represents the model behind the search form of `app\models\PenjualanItem`.
 */
class PenjualanItemSearch extends PenjualanItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'penjualan_id', 'stok_id'], 'integer'],
            [['qty', 'harga', 'subtotal', 'diskon', 'ppn'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = PenjualanItem::find();

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
            'penjualan_id' => $this->penjualan_id,
            'stok_id' => $this->stok_id,
            'qty' => $this->qty,
            'harga' => $this->harga,
            'subtotal' => $this->subtotal,
            'diskon' => $this->diskon,
            'ppn' => $this->ppn,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
