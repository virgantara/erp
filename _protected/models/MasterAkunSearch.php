<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\MasterAkun;

/**
 * MasterAkunSearch represents the model behind the search form of `app\models\MasterAkun`.
 */
class MasterAkunSearch extends MasterAkun
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode_akun', 'uraian_akun'], 'safe'],
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
        $query = MasterAkun::find();

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
        $query->andFilterWhere(['like', 'kode_akun', $this->kode_akun])
            ->andFilterWhere(['like', 'uraian_akun', $this->uraian_akun]);

        return $dataProvider;
    }
}
