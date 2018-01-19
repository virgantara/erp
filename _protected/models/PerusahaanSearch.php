<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perusahaan;

/**
 * PerusahaanSearch represents the model behind the search form about `app\models\Perusahaan`.
 */
class PerusahaanSearch extends Perusahaan
{

    public $jenisPerusahaan;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_perusahaan', 'level', 'created_at', 'updated_at'], 'integer'],
            [['nama', 'email', 'alamat', 'telp', 'jenisPerusahaan'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Perusahaan::find();

        // add conditions that should always apply here

        $query->joinWith('jenis0');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['jenisPerusahaan'] = [
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
            'id_perusahaan' => $this->id_perusahaan,
            'level' => $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'nama', $this->jenisPerusahaan]);

        return $dataProvider;
    }
}
