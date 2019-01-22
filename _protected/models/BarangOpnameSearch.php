<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangOpname;

/**
 * BarangOpnameSearch represents the model behind the search form of `app\models\BarangOpname`.
 */
class BarangOpnameSearch extends BarangOpname
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'perusahaan_id', 'departemen_stok_id', 'bulan', 'tahun'], 'integer'],
            [['stok', 'stok_riil', 'stok_lalu'], 'number'],
            [['tanggal', 'created_at', 'updated_at'], 'safe'],
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
        $query = BarangOpname::find();

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
            'barang_id' => $this->barang_id,
            'perusahaan_id' => $this->perusahaan_id,
            'departemen_stok_id' => $this->departemen_stok_id,
            'stok' => $this->stok,
            'stok_riil' => $this->stok_riil,
            'stok_lalu' => $this->stok_lalu,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'tanggal' => $this->tanggal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
