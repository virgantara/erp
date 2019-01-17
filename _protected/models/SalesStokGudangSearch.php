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
    public $kodeBarang;
    public $durasiExp;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_stok', 'id_gudang', 'id_barang','durasiExp'], 'integer'],
            [['jumlah'], 'number'],
            [['namaGudang','namaBarang','kodeBarang','durasiExp','exp_date','batch_no'], 'safe'],
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
        // $query->groupBy([self::tableName().'.batch_no']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['barang.nama_barang'=>SORT_ASC],
            'desc' => ['barang.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['kodeBarang'] = [
            'asc' => ['barang.kode_barang'=>SORT_ASC],
            'desc' => ['barang.kode_barang'=>SORT_DESC]
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

        if(!empty($this->durasiExp)){
            $time = strtotime(date('Y-m-d'));
            $final = date("Y-m-d", strtotime("+".$this->durasiExp." month", $time));
            // print_r($final);exit;
            $query->where(['between', 'exp_date', date('Y-m-d'), $final ]);
            $query->orderBy('exp_date','ASC');
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     self::tableName().'.id_stok' => $this->id_stok,
        //     self::tableName().'.id_gudang' => $this->id_gudang,
        //     self::tableName().'.id_barang' => $this->id_barang,
        //     // 'sales_stok_gudang.jumlah' => $this->jumlah,
        //     // 'created' => $this->created,
        // ]);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'barang.kode_barang', $this->kodeBarang])
            ->andFilterWhere(['like', 'gudang.jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'gudang.nama', $this->namaGudang]);

        return $dataProvider;
    }

    public function searchStok($params,$id=0)
    {
        $query = SalesStokGudang::find()->alias('t');
        
        $query->joinWith(['gudang as gudang','barang as barang']);
        $query->where([
            't.is_hapus'=>0,
            'barang.is_hapus' => 0,
            't.id_gudang' => $id,
            'gudang.id_perusahaan'=>Yii::$app->user->identity->perusahaan_id,

        ]);

        // $query->groupBy(['barang.id_barang']);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['barang.nama_barang'=>SORT_ASC],
            'desc' => ['barang.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['kodeBarang'] = [
            'asc' => ['barang.kode_barang'=>SORT_ASC],
            'desc' => ['barang.kode_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaGudang'] = [
            'asc' => ['gudang.nama'=>SORT_ASC],
            'desc' => ['gudang.nama'=>SORT_DESC]
        ];
          


        $this->load($params);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
             ->andFilterWhere(['like', 'barang.kode_barang', $this->kodeBarang])
            ->andFilterWhere(['like', 'gudang.jumlah', $this->jumlah])
            ->andFilterWhere(['like', 'gudang.nama', $this->namaGudang]);


       

        return $dataProvider;
    }
}
