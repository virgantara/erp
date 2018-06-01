<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestOrder;

/**
 * RequestOrderSearch represents the model behind the search form of `app\models\RequestOrder`.
 */
class RequestOrderSearch extends RequestOrder
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'petugas1', 'petugas2', 'perusahaan_id'], 'integer'],
            [['no_ro', 'tanggal_pengajuan', 'tanggal_penyetujuan', 'created','is_approved'], 'safe'],
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
        $query = RequestOrder::find();

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
            'petugas1' => $this->petugas1,
            'petugas2' => $this->petugas2,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            'tanggal_penyetujuan' => $this->tanggal_penyetujuan,
            'perusahaan_id' => $this->perusahaan_id,
            'created' => $this->created,
            'is_approved' => $this->is_approved
        ]);

        $query->andFilterWhere(['like', 'no_ro', $this->no_ro]);

        return $dataProvider;
    }
}
