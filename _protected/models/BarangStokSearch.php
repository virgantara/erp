<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangStok;

/**
 * BarangStokSearch represents the model behind the search form of `app\models\BarangStok`.
 */
class BarangStokSearch extends BarangStok
{
    public $namaBarang;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['stok', 'stok_bulan_lalu', 'tebus_liter', 'tebus_rupiah', 'dropping', 'sisa_do'], 'number'],
            [['tanggal', 'created','namaBarang'], 'safe'],
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
        $query = BarangStok::find();

        $query->joinWith(['barang']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['nama_barang'=>SORT_ASC],
            'desc' => ['nama_barang'=>SORT_DESC]
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $userPt = Yii::$app->user->identity->perusahaan_id;
        $query->andFilterWhere(['perusahaan_id'=>$userPt]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'barang_id' => $this->barang_id,
            'stok' => $this->stok,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'tanggal' => $this->tanggal,
            'stok_bulan_lalu' => $this->stok_bulan_lalu,
            'tebus_liter' => $this->tebus_liter,
            'tebus_rupiah' => $this->tebus_rupiah,
            'dropping' => $this->dropping,
            'sisa_do' => $this->sisa_do,
            'perusahaan_id' => $this->perusahaan_id,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'nama_barang', $this->namaBarang]);

        return $dataProvider;
    }
}
