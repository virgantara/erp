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

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_barang', 'id_satuan', 'id_perusahaan'], 'integer'],
            [['nama_barang', 'created','kode_barang'], 'safe'],
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
        $userPt = Yii::$app->user->identity->perusahaan_id;
        
        $query->andFilterWhere(['id_perusahaan'=>$userPt]);
        
       
        $query->andFilterWhere(['like', 'nama_barang', $this->nama_barang])
            ->andFilterWhere(['like', 'harga_beli', $this->harga_beli])
            ->andFilterWhere(['like', 'harga_jual', $this->harga_jual])
            ->andFilterWhere(['like', 'id_satuan', $this->id_satuan]);

        return $dataProvider;
    }
}
