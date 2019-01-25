<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Penjualan;
use Yii;
/**
 * PenjualanSearch represents the model behind the search form of `app\models\Penjualan`.
 */
class PenjualanSearch extends Penjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departemen_id', 'customer_id', 'is_approved'], 'integer'],
            [['kode_penjualan', 'kode_daftar', 'tanggal', 'created_at', 'updated_at','kode_transaksi'], 'safe'],
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
    public function searchTanggal($params)
    {
        $query = Penjualan::find();

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

        $this->tanggal_awal = date('Y-m-d',strtotime($params['Penjualan']['tanggal_awal']));
        $this->tanggal_akhir = date('Y-m-d',strtotime($params['Penjualan']['tanggal_akhir']));
        if(!empty($params))
        {
            
            $query->where(['departemen_id'=>Yii::$app->user->identity->departemen]);
            $query->andFilterWhere(['between', 'tanggal', $this->tanggal_awal, $this->tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
        }

        else{
            $query->where(['id'=>'a']);
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'tanggal' => $this->tanggal,
        //     'departemen_id' => $this->departemen_id,
        //     'customer_id' => $this->customer_id,
        //     'is_approved' => $this->is_approved,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ]);

        // $query->andFilterWhere(['like', 'kode_penjualan', $this->kode_penjualan])
        //     ->andFilterWhere(['like', 'kode_daftar', $this->kode_daftar]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = Penjualan::find();

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
        $query->andFilterWhere([
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'departemen_id' => $this->departemen_id,
            'customer_id' => $this->customer_id,
            'is_approved' => $this->is_approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'kode_penjualan', $this->kode_penjualan])
            ->andFilterWhere(['like', 'kode_daftar', $this->kode_daftar]);

        return $dataProvider;
    }
}
