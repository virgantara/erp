<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ObatDetil;

/**
 * ObatDetilSearch represents the model behind the search form of `app\models\ObatDetil`.
 */
class ObatDetilSearch extends ObatDetil
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id'], 'integer'],
            [['nama_generik', 'kekuatan', 'satuan_kekuatan', 'jns_sediaan', 'b_i_r', 'gen_non', 'nar_p_non', 'oakrl', 'kronis'], 'safe'],
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
        $query = ObatDetil::find();

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
            'barang_id' => $this->barang_id,
        ]);

        $query->andFilterWhere(['like', 'nama_generik', $this->nama_generik])
            ->andFilterWhere(['like', 'kekuatan', $this->kekuatan])
            ->andFilterWhere(['like', 'satuan_kekuatan', $this->satuan_kekuatan])
            ->andFilterWhere(['like', 'jns_sediaan', $this->jns_sediaan])
            ->andFilterWhere(['like', 'b_i_r', $this->b_i_r])
            ->andFilterWhere(['like', 'gen_non', $this->gen_non])
            ->andFilterWhere(['like', 'nar_p_non', $this->nar_p_non])
            ->andFilterWhere(['like', 'oakrl', $this->oakrl])
            ->andFilterWhere(['like', 'kronis', $this->kronis]);

        return $dataProvider;
    }
}
