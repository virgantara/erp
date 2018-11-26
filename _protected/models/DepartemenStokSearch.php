<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DepartemenStok;

/**
 * PerusahaanSubStokSearch represents the model behind the search form of `app\models\PerusahaanSubStok`.
 */
class DepartemenStokSearch extends DepartemenStok
{

    public $namaDepartemen;
    public $namaBarang;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'departemen_id', 'bulan', 'tahun', 'ro_item_id'], 'integer'],
            [['stok_akhir', 'stok_awal', 'stok_bulan_lalu', 'stok'], 'number'],
            [['created', 'tanggal','namaBarang','namaDepartemen'], 'safe'],
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
        $query = DepartemenStok::find();
        $query->joinWith(['departemen as departemen','barang as barang']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaDepartemen'] = [
            'asc' => ['departemen.nama'=>SORT_ASC],
            'desc' => ['departemen.nama'=>SORT_DESC]
        ];

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'barang_id' => $this->barang_id,
            'departemen_id' => $this->departemen_id,
            'stok_akhir' => $this->stok_akhir,
            'stok_awal' => $this->stok_awal,
            'created' => $this->created,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'tanggal' => $this->tanggal,
            'stok_bulan_lalu' => $this->stok_bulan_lalu,
            'stok' => $this->stok,
            'ro_item_id' => $this->ro_item_id,
        ]);

        $userLevel = Yii::$app->user->identity->access_role;    
        $where = [];
        if($userLevel == 'operatorCabang' || $userLevel == 'operatorUnit'){
            $departemen = Yii::$app->user->identity->departemen;
            $query->andFilterWhere(['departemen_id' => $departemen]);
        }


         $query->andFilterWhere(['like', 'departemen.nama', $this->namaDepartemen])
        ->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang]);

        return $dataProvider;
    }
}
