<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BbmDispenserLog;

/**
 * BbmDispenserLogSearch represents the model behind the search form of `app\models\BbmDispenserLog`.
 */
class BbmDispenserLogSearch extends BbmDispenserLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dispenser_id', 'shift_id', 'perusahaan_id'], 'integer'],
            [['jumlah'], 'number'],
            [['tanggal', 'created'], 'safe'],
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
        $query = BbmDispenserLog::find();

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
            'dispenser_id' => $this->dispenser_id,
            'shift_id' => $this->shift_id,
            'perusahaan_id' => $this->perusahaan_id,
            'jumlah' => $this->jumlah,
            'tanggal' => $this->tanggal,
            'created' => $this->created,
        ]);

        return $dataProvider;
    }
}
