<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Notif;

/**
 * NotifSearch represents the model behind the search form of `app\models\Notif`.
 */
class NotifSearch extends Notif
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departemen_from_id', 'departemen_to_id', 'is_read_from', 'is_read_to', 'is_hapus'], 'integer'],
            [['keterangan', 'created'], 'safe'],
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
        $query = Notif::find();

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
            'departemen_from_id' => $this->departemen_from_id,
            'departemen_to_id' => $this->departemen_to_id,
            'is_read_from' => $this->is_read_from,
            'is_read_to' => $this->is_read_to,
            'is_hapus' => $this->is_hapus,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
