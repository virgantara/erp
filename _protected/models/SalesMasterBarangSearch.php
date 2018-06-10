<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesMasterBarang;

/**
 * SalesBarangSearch represents the model behind the search form of `app\models\SalesBarang`.
 */
class SalesMasterBarangSearch extends SalesMasterBarang
{
    public $namaSatuan;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'id_satuan', 'id_perusahaan'], 'integer'],
            [['nama_barang', 'created','namaSatuan'], 'safe'],
            [['harga_beli', 'harga_jual'], 'number'],
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
        $query = SalesMasterBarang::find()->where(['is_hapus'=>0]);
        
        $query->joinWith('satuan as satuan');
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
        $userPt = Yii::$app->user->identity->perusahaan_id;
        
        $query->andFilterWhere(['id_perusahaan'=>$userPt]);
        
       
        $query->andFilterWhere(['like', 'nama_barang', $this->nama_barang])
            ->andFilterWhere(['like', 'harga_beli', $this->harga_beli])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual])
            ->andFilterWhere(['like', 'satuan.nama', $this->namaSatuan]);

        return $dataProvider;
    }
}
