<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanResep;

/**
 * PenjualanResepSearch represents the model behind the search form of `app\models\PenjualanResep`.
 */
class PenjualanResepSearch extends PenjualanResep
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'penjualan_id', 'pasien_id', 'dokter_id', 'jenis_rawat'], 'integer'],
            [['kode_daftar', 'created_at', 'updated_at'], 'safe'],
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
        $query = PenjualanResep::find();

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
            'pasien_id' => $this->pasien_id,
            'dokter_id' => $this->dokter_id,
            'jenis_rawat' => $this->jenis_rawat,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'kode_daftar', $this->kode_daftar]);

        return $dataProvider;
    }
}
