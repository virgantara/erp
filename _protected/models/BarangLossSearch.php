<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BarangLoss;

/**
 * BarangLossSearch represents the model behind the search form of `app\models\BarangLoss`.
 */
class BarangLossSearch extends BarangLoss
{

    public $namaBarang;
    // public $selisih;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'bulan', 'tahun', 'perusahaan_id'], 'integer'],
            [['tanggal', 'jam', 'created','namaBarang'], 'safe'],
            [['stok_adm', 'stok_riil', 'loss', 'biaya_loss'], 'number'],
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
        $query = BarangLoss::find();
        $query->joinWith('barang as b');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaBarang'] = [
            'asc' => ['b.nama_barang'=>SORT_ASC],
            'desc' => ['b.nama_barang'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!empty($this->loss))
        {
            switch ($this->loss) {
                case 0:
                    $query->andFilterWhere(['<', 'loss', (1 / 100)]);
                    break;
                case 1:
                    $query->where(['>=', 'loss', (1 / 100)]);
                    $query->andWhere(['<=', 'loss', (5 / 100)]);
                    break;
                case 2:
                    $query->andFilterWhere(['>', 'loss', (5 / 100)]);
                    break;

                
            }
        }        

        // $query->andFilterWhere(['like', 'b.nama_barang', $this->namaBarang])
        $query->andFilterWhere(['like', 'b.nama_barang', $this->namaBarang]);

        return $dataProvider;
    }
}
