<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrRawatInapAlkesObat;

/**
 * TrRawatInapAlkesObatSearch represents the model behind the search form of `app\models\TrRawatInapAlkesObat`.
 */
class TrRawatInapAlkesObatSearch extends TrRawatInapAlkesObat
{
    public $namaDokter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_rawat_inap', 'id_dokter', 'jumlah'], 'integer'],
            [['kode_alkes', 'keterangan', 'created', 'id_m_obat_akhp', 'tanggal_input','namaDokter'], 'safe'],
            [['nilai'], 'number'],
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
        $query = TrRawatInapAlkesObat::find()->where(['id_rawat_inap'=>$this->id_rawat_inap]);
        $query->joinWith(['dokter as d']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaDokter'] = [
            'asc' => ['d.nama_dokter'=>SORT_ASC],
            'desc' => ['d.nama_dokter'=>SORT_DESC]
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
            'nilai' => $this->nilai,
            'created' => $this->created,
            'tanggal_input' => $this->tanggal_input,
            'id_dokter' => $this->id_dokter,
            'jumlah' => $this->jumlah,
        ]);


        $query->andFilterWhere(['like', 'kode_alkes', $this->kode_alkes])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'd.nama_dokter', $this->namaDokter]);

        return $dataProvider;
    }
}
