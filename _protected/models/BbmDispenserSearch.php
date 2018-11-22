<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BbmDispenser;

/**
 * BbmDispenserSearch represents the model behind the search form of `app\models\BbmDispenser`.
 */
class BbmDispenserSearch extends BbmDispenser
{

    public $namaPerusahaan;
    public $namaBarang;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perusahaan_id', 'barang_id'], 'integer'],
            [['nama','namaPerusahaan','namaBarang'], 'safe'],
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
        $query = BbmDispenser::find();

        $query->joinWith(['perusahaan as perusahaan','barang as barang']);

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
            'perusahaan_id' => $this->perusahaan_id,
            'barang_id' => $this->barang_id,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'perusahaan.nama', $this->namaPerusahaan]);

        return $dataProvider;
    }
}
