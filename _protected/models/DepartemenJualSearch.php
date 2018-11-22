<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DepartemenJual;

/**
 * DepartemenJualSearch represents the model behind the search form of `app\models\DepartemenJual`.
 */
class DepartemenJualSearch extends DepartemenJual
{
     public $namaBarang;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','perusahaan_id'], 'integer'],
            [['jumlah'], 'number'],
            [['tanggal', 'created','namaBarang'], 'safe'],
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
        $query = DepartemenJual::find();

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

            'jumlah' => $this->jumlah,
            'tanggal' => $this->tanggal,
            'perusahaan_id' => $this->perusahaan_id,
            'created' => $this->created,
        ]);

         $query->andFilterWhere(['like', 'b.nama_barang', $this->namaBarang]);

        return $dataProvider;
    }
}
