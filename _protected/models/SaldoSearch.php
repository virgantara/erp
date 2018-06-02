<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Saldo;

/**
 * SaldoSearch represents the model behind the search form of `app\models\Saldo`.
 */
class SaldoSearch extends Saldo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bulan', 'tahun'], 'integer'],
            [['nilai_awal', 'nilai_akhir'], 'number'],
            [['created','jenis','perusahaan_id'], 'safe'],
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
        $query = Saldo::find();

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
            'nilai_awal' => $this->nilai_awal,
            'nilai_akhir' => $this->nilai_akhir,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
