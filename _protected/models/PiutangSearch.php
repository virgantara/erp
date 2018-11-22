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
    public $namaCustomer;
    public $namaBarang;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perkiraan_id', 'perusahaan_id', 'customer_id', 'is_lunas', 'barang_id'], 'integer'],
            [['kwitansi', 'penanggung_jawab', 'keterangan', 'tanggal', 'created', 'kode_transaksi', 'no_nota','namaPerkiraan','namaBarang','namaCustomer'], 'safe'],
            [['qty', 'rupiah'], 'number'],
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

        $query->joinWith(['perkiraan as p','barang as b','customer as c']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->sort->attributes['namaPerkiraan'] = [
            'asc' => ['p.nama'=>SORT_ASC],
            'desc' => ['p.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['b.nama_barang'=>SORT_ASC],
            'desc' => ['b.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaCustomer'] = [
            'asc' => ['c.nama'=>SORT_ASC],
            'desc' => ['c.nama'=>SORT_DESC]
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
            'qty' => $this->qty,
            'created' => $this->created,
            'perusahaan_id' => $this->perusahaan_id,
            'customer_id' => $this->customer_id,
            'is_lunas' => $this->is_lunas,
            'barang_id' => $this->barang_id,
            'rupiah' => $this->rupiah,
        ]);

        $query->andFilterWhere(['like', 'kwitansi', $this->kwitansi])
            ->andFilterWhere(['like', 'penanggung_jawab', $this->penanggung_jawab])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'kode_transaksi', $this->kode_transaksi])
            ->andFilterWhere(['like', 'no_nota', $this->no_nota])
            ->andFilterWhere(['like', 'b.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'c.nama', $this->namaCustomer])
            ->andFilterWhere(['like', 'p.nama', $this->namaPerkiraan]);

        return $dataProvider;
    }
}
