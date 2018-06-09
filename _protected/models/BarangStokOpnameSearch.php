<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangStokOpname;

/**
 * BarangStokOpnameSearch represents the model behind the search form of `app\models\BarangStokOpname`.
 */
class BarangStokOpnameSearch extends BarangStokOpname
{

    public $namaBarang;
    public $namaGudang;
    public $namaPerusahaan;
    public $namaShift;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'perusahaan_id', 'gudang_id', 'shift_id', 'bulan', 'tahun'], 'integer'],
            [['stok', 'stok_lalu'], 'number'],
            [['tanggal', 'created','namaPerusahaan','namaBarang','namaShift','namaGudang','jam'], 'safe'],
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
        $query = BarangStokOpname::find();

        $query->joinWith(['perusahaan as perusahaan','barang as barang','shift','gudang as gudang']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaPerusahaan'] = [
            'asc' => ['perusahaan.nama'=>SORT_ASC],
            'desc' => ['perusahaan.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['barang.nama_barang'=>SORT_ASC],
            'desc' => ['barang.nama_barang'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaGudang'] = [
            'asc' => ['gudang.nama'=>SORT_ASC],
            'desc' => ['gudang.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaShift'] = [
            'asc' => ['shift.nama'=>SORT_ASC],
            'desc' => ['shift.nama'=>SORT_DESC]
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
            'perusahaan_id' => $this->perusahaan_id,
            'gudang_id' => $this->gudang_id,
            'shift_id' => $this->shift_id,
            'stok' => $this->stok,
            'stok_lalu' => $this->stok_lalu,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'tanggal' => $this->tanggal,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'perusahaan.nama', $this->namaPerusahaan])
            ->andFilterWhere(['like', 'shift.nama', $this->namaShift])
            ->andFilterWhere(['like', 'gudang.nama', $this->namaGudang]);

        $query->orderBy(['tanggal'=>'ASC']);

        return $dataProvider;
    }
}
