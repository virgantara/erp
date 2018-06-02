<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Neraca;

/**
 * NeracaSearch represents the model behind the search form of `app\models\Neraca`.
 */
class NeracaSearch extends Neraca
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perkiraan_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['nominal'], 'number'],
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

    public function searchAkuns($params)
    {
        $query = Perkiraan::find();
        $query->where(['kode'=>$params]);
        // $query->andWhere('LENGTH(kode) = 3');
        $query->andFilterWhere(['perusahaan_id'=>Yii::$app->user->identity->perusahaan_id]);

        return $query->one();
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
        $query = Neraca::find();

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
            'perkiraan_id' => $this->perkiraan_id,
            'nominal' => $this->nominal,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'perusahaan_id' => $this->perusahaan_id,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
