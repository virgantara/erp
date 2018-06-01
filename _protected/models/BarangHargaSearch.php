<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangHarga;

/**
 * BarangHargaSearch represents the model behind the search form of `app\models\BarangHarga`.
 */
class BarangHargaSearch extends BarangHarga
{

    public $namaBarang;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'pilih'], 'integer'],
            [['harga_beli', 'harga_jual'], 'number'],
            [['created','namaBarang'], 'safe'],
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
        $query = BarangHarga::find();

        $query->joinWith(['barang as barang']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['barang.nama_barang'=>SORT_ASC],
            'desc' => ['barang.nama_barang'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['barang.id_perusahaan'=>Yii::$app->user->identity->perusahaan_id]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'barang_id' => $this->barang_id,
            'harga_beli' => $this->harga_beli,
            'harga_jual' => $this->harga_jual,
            'pilih' => $this->pilih,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'harga_beli', $this->harga_beli])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual]);


        return $dataProvider;
    }
}
