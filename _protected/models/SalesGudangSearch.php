<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesGudang;

/**
 * SalesGudangSearch represents the model behind the search form of `app\models\SalesGudang`.
 */
class SalesGudangSearch extends SalesGudang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_gudang', 'id_perusahaan','is_sejenis','is_penuh'], 'integer'],
            [['kapasitas'], 'number'],
            [['nama', 'alamat', 'telp','kapasitas','is_sejenis','is_penuh'], 'safe'],
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
        $query = SalesGudang::find()->where(['is_hapus'=>0]);

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
        
        $query->andFilterWhere(['id_perusahaan'=>Yii::$app->user->identity->perusahaan_id]);
        

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'kapasitas', $this->kapasitas])
            ->andFilterWhere(['like', 'is_sejenis', $this->is_sejenis])
            ->andFilterWhere(['like', 'is_penuh', $this->is_penuh])
            ->andFilterWhere(['like', 'telp', $this->telp]);

        return $dataProvider;
    }

    public function searchBarangGudang($id_barang,$id_gudang)
    {
        $query = SalesStokGudang::find();

        $query->joinWith(['gudang as gudang','barang as barang']);
        $query->where([
            'barang.is_hapus' => 0,
            'erp_sales_stok_gudang.is_hapus' => 0,
            'barang.id_barang' => $id_barang,
            'gudang.id_gudang' => $id_gudang,
            'gudang.id_perusahaan'=>Yii::$app->user->identity->perusahaan_id,

        ]);
        // $query->andWhere(['gudang.id_perusahaan'=>Yii::$app->user->identity->perusahaan_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       

        return $dataProvider;
    }
}
