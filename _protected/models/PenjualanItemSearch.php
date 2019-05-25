<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\PenjualanItem;
use Yii;
/**
 * PenjualanItemSearch represents the model behind the search form of `app\models\PenjualanItem`.
 */
class PenjualanItemSearch extends PenjualanItem
{
    public $tanggal_awal;
    public $tanggal_akhir;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'penjualan_id', 'stok_id'], 'integer'],
            [['qty', 'harga', 'subtotal', 'diskon', 'ppn'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = PenjualanItem::find();

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
            'penjualan_id' => $this->penjualan_id,
            'stok_id' => $this->stok_id,
            'qty' => $this->qty,
            'harga' => $this->harga,
            'subtotal' => $this->subtotal,
            'diskon' => $this->diskon,
            'ppn' => $this->ppn,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }

    public function searchTanggal($params,$status_penjualan=0,$order=SORT_ASC,$limit=100)
    {
        $query = PenjualanItem::find();

        // add conditions that should always apply here

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

        $query->joinWith(['penjualan p','penjualan.penjualanResep as pr','penjualan.departemen as d']);
        $query->where(['p.departemen_id'=>Yii::$app->user->identity->departemen]);
        if($status_penjualan != 0){

            $query->andWhere(['p.status_penjualan'=>$status_penjualan]);

        }

        // $dataProvider->sort->attributes['namaUnit'] = [
        //     'asc' => ['d.nama'=>SORT_ASC],
        //     'desc' => ['d.nama'=>SORT_DESC]
        // ];

        
        $this->tanggal_awal = date('Y-m-d',strtotime($params['Penjualan']['tanggal_awal']));
        $this->tanggal_akhir = date('Y-m-d',strtotime($params['Penjualan']['tanggal_akhir']));
        if(!empty($params))
        {
            

            if(!empty($params['unit_id'])){
                $query->andWhere(['pr.unit_id'=>$params['unit_id']]);    
            }

            if(!empty($params['jenis_resep_id'])){
                $query->andWhere(['pr.jenis_resep_id'=>$params['jenis_resep_id']]);    
            }

            if(!empty($params['jenis_rawat'])){
                $query->andWhere(['pr.jenis_rawat'=>$params['jenis_rawat']]);    
            }

            if(!empty($params['customer_id'])){
                $query->andWhere(['p.customer_id'=>$params['customer_id']]);    
            }

            // print_r($this->tanggal_akhir);exit;
            $query->andFilterWhere(['between', 'p.tanggal', $this->tanggal_awal, $this->tanggal_akhir]);
            $query->orderBy(['p.tanggal'=>$order]);
        }

        else{
            $query->where(['p.id'=>'a']);
        }

        
        $query->limit = $limit;

        return $query->all();
    }
}
