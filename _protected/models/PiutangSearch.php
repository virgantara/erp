<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Piutang;

/**
 * PiutangSearch represents the model behind the search form of `app\models\Piutang`.
 */
class PiutangSearch extends Piutang
{

    public $namaPerkiraan;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perkiraan_id', 'perusahaan_id','is_lunas'], 'integer'],
            [['kwitansi', 'penanggung_jawab', 'keterangan', 'tanggal', 'created', 'kode_transaksi','namaPerkiraan'], 'safe'],
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
        $query = Piutang::find();

        $query->joinWith(['perkiraan as p']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaPerkiraan'] = [
            'asc' => ['p.nama'=>SORT_ASC],
            'desc' => ['p.nama'=>SORT_DESC]
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
            'perkiraan_id' => $this->perkiraan_id,
            'tanggal' => $this->tanggal,
            'nilai' => $this->nilai,
            'created' => $this->created,
            'perusahaan_id' => $this->perusahaan_id,
            'is_lunas' => $this->is_lunas
        ]);

        $query->andFilterWhere(['like', 'kwitansi', $this->kwitansi])
            ->andFilterWhere(['like', 'penanggung_jawab', $this->penanggung_jawab])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'kode_transaksi', $this->kode_transaksi])
            ->andFilterWhere(['like', 'p.perkiraan', $this->namaPerkiraan]);

        return $dataProvider;
    }
}
