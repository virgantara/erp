<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestOrderItem;

/**
 * RequestOrderItemSearch represents the model behind the search form of `app\models\RequestOrderItem`.
 */
class RequestOrderItemSearch extends RequestOrderItem
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ro_id', 'stok_id', 'item_id'], 'integer'],
            [['jumlah_minta', 'jumlah_beri'], 'number'],
            [['satuan', 'keterangan', 'created'], 'safe'],
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
        $query = RequestOrderItem::find();

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
            'ro_id' => $this->ro_id,
            'stok_id' => $this->stok_id,
            'jumlah_minta' => $this->jumlah_minta,
            'jumlah_beri' => $this->jumlah_beri,
            'created' => $this->created,
            'item_id' => $this->item_id,
        ]);

        $query->andFilterWhere(['like', 'satuan', $this->satuan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
