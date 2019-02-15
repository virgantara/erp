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
    public $namaUnit;
    public $namaPasien;
    public $RMPasien;
    public $jenisPasien;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'departemen_id', 'customer_id', 'status_penjualan'], 'integer'],
            [['kode_penjualan', 'kode_daftar', 'tanggal', 'created_at', 'updated_at','kode_transaksi','namaUnit','status_penjualan','namaPasien','RMPasien','jenisPasien'], 'safe'],
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
    public function searchTanggal($params,$status_penjualan=0)
    {
        $query = Penjualan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['penjualanResep as pr','departemen as d']);

        if($status_penjualan != 0){
            $query->where(['status_penjualan'=>$status_penjualan]);
        }

        $dataProvider->sort->attributes['namaUnit'] = [
            'asc' => ['d.nama'=>SORT_ASC],
            'desc' => ['d.nama'=>SORT_DESC]
        ];

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

            if(!empty($params['unit_id'])){
                $query->andWhere(['pr.unit_id'=>$params['unit_id']]);    
            }

            if(!empty($params['jenis_resep_id'])){
                $query->andWhere(['pr.jenis_resep_id'=>$params['jenis_resep_id']]);    
            }

            $query->andFilterWhere(['between', 'tanggal', $this->tanggal_awal, $this->tanggal_akhir]);
            $query->orderBy(['tanggal'=>SORT_ASC]);
        }

        else{
            $query->where([self::tableName().'.id'=>'a']);
        }

        

        return $dataProvider;
    }




    public function search($params)
    {
        $query = Penjualan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['penjualanResep as pr','departemen as d']);

        $dataProvider->sort->attributes['namaUnit'] = [
            'asc' => ['d.nama'=>SORT_ASC],
            'desc' => ['d.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaPasien'] = [
            'asc' => ['pr.pasien_nama'=>SORT_ASC],
            'desc' => ['pr.pasien_nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['RMPasien'] = [
            'asc' => ['pr.pasien_id'=>SORT_ASC],
            'desc' => ['pr.pasien_id'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['jenisPasien'] = [
            'asc' => ['pr.pasien_jenis'=>SORT_ASC],
            'desc' => ['pr.pasien_jenis'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        
        if(Yii::$app->user->can('operatorCabang')){
            $query->where(['departemen_id'=> Yii::$app->user->identity->departemen]);
        }

        $query->andFilterWhere(['like', 'pr.pasien_jenis', $this->jenisPasien])
            ->andFilterWhere(['like', 'pr.pasien_nama', $this->namaPasien])
            ->andFilterWhere(['like', 'pr.pasien_id', $this->RMPasien])
            ->andFilterWhere(['like', 'status_penjualan', $this->status_penjualan])
            ->andFilterWhere(['like', 'd.nama', $this->namaUnit])
            ->andFilterWhere(['like', 'kode_penjualan', $this->kode_penjualan])
            ->andFilterWhere(['like', 'kode_daftar', $this->kode_daftar])
            ->andFilterWhere(['like', 'tanggal', $this->tanggal]);

        return $dataProvider;
    }
}
