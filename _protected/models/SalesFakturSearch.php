<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesFaktur;

/**
 * SalesFakturSearch represents the model behind the search form of `app\models\SalesFaktur`.
 */
class SalesFakturSearch extends SalesFaktur
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_faktur', 'id_suplier', 'id_perusahaan'], 'integer'],
            [['no_faktur', 'created', 'tanggal_faktur'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = SalesFaktur::find();

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
            'id_faktur' => $this->id_faktur,
            'id_suplier' => $this->id_suplier,
            'created' => $this->created,
            'tanggal_faktur' => $this->tanggal_faktur,
            'id_perusahaan' => $this->id_perusahaan,
        ]);

        $query->andFilterWhere(['like', 'no_faktur', $this->no_faktur]);

        return $dataProvider;
    }
}
