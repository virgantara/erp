<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Departemen;

/**
 * PerusahaanSubSearch represents the model behind the search form of `app\models\PerusahaanSub`.
 */
class DepartemenSearch extends Departemen
{

    public $namaPerusahaan;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perusahaan_id'], 'integer'],
            [['nama', 'created','namaPerusahaan','namaUser','kode'], 'safe'],
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
        $query = Departemen::find();

        $query->joinWith(['perusahaan as perusahaan']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->sort->attributes['namaPerusahaan'] = [
            'asc' => ['perusahaan.nama'=>SORT_ASC],
            'desc' => ['perusahaan.nama'=>SORT_DESC]
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
            'perusahaan_id' => $this->perusahaan_id,
           
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
        ->andFilterWhere(['like', 'kode', $this->kode])
        ->andFilterWhere(['like', 'perusahaan.nama', $this->namaPerusahaan]);

        return $dataProvider;
    }
}
