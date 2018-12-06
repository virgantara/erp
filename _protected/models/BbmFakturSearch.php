<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BbmFaktur;

/**
 * BbmFakturSearch represents the model behind the search form of `app\models\BbmFaktur`.
 */
class BbmFakturSearch extends BbmFaktur
{
    public $namaSuplier;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'suplier_id', 'perusahaan_id','is_selesai'], 'integer'],
            [['no_so', 'tanggal_so', 'created_at','namaSuplier'], 'safe'],
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
        $query = BbmFaktur::find();

        $query->joinWith('suplier as suplier');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaSuplier'] = [
            'asc' => ['nama'=>SORT_ASC],
            'desc' => ['nama'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'suplier_id' => $this->suplier_id,
            
            'tanggal_so' => $this->tanggal_so,
            'perusahaan_id' => $this->perusahaan_id,
            'created_at' => $this->created_at,
            'is_selesai' => $this->is_selesai
        ]);

        $query->andFilterWhere(['like', 'suplier.nama', $this->namaSuplier])
            ->andFilterWhere(['like', 'no_so', $this->no_so]);

        return $dataProvider;
    }
}
