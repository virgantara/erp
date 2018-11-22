<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesSuplier;

/**
 * SalesSuplierSearch represents the model behind the search form of `app\models\SalesSuplier`.
 */
class SalesSuplierSearch extends SalesSuplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_suplier', 'id_perusahaan'], 'integer'],
            [['nama', 'alamat', 'telp', 'email', 'created'], 'safe'],
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
        $query = SalesSuplier::find();

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
        

        $query->andFilterWhere(['id_perusahaan'=>Yii::$app->user->identity->perusahaan_id]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
