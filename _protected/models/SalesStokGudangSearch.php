<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SalesStokGudang;

/**
 * SalesStokGudangSearch represents the model behind the search form of `app\models\SalesStokGudang`.
 */
class SalesStokGudangSearch extends SalesStokGudang
{

    public $namaGudang;
    public $namaBarang;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok', 'id_gudang', 'id_barang'], 'integer'],
            [['jumlah'], 'number'],
            [['created','namaGudang','namaBarang'], 'safe'],
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
        $query = SalesStokGudang::find()->where([self::tableName().'.is_hapus'=>0]);

        $query->joinWith(['gudang as gudang','barang as barang']);

        $query->andFilterWhere(['gudang.id_perusahaan'=>Yii::$app->user->identity->perusahaan_id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['barang.nama_barang'=>SORT_ASC],
            'desc' => ['barang.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaGudang'] = [
            'asc' => ['gudang.nama'=>SORT_ASC],
            'desc' => ['gudang.nama'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_stok' => $this->id_stok,
            'id_gudang' => $this->id_gudang,
            'id_barang' => $this->id_barang,
            // 'sales_stok_gudang.jumlah' => $this->jumlah,
            // 'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'gudang.jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'gudang.nama', $this->namaGudang]);

        return $dataProvider;
    }
}
