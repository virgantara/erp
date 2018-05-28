<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesBarang;

/**
 * SalesBarangSearch represents the model behind the search form of `app\models\SalesBarang`.
 */
class SalesBarangSearch extends SalesBarang
{
    public $namaSatuan;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'id_satuan', 'id_perusahaan', 'id_gudang'], 'integer'],
            [['nama_barang', 'created','namaSatuan','jumlah'], 'safe'],
            [['harga_beli', 'harga_jual','jumlah'], 'number'],
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
        $query = SalesBarang::find();
        
        $query->joinWith('satuan');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaSatuan'] = [
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
       
        $session = Yii::$app->session;

        if($session->isActive)
        {
            $userPt = $session->get('perusahaan');
            
            $query->andFilterWhere(['id_perusahaan'=>$userPt]);
        }
       
        $query->andFilterWhere(['like', 'nama_barang', $this->nama_barang])
            ->andFilterWhere(['like', 'jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'harga_beli', $this->harga_beli])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual])
            ->andFilterWhere(['like', 'satuan_barang.nama', $this->namaSatuan]);

        return $dataProvider;
    }
}
