<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BbmJual;

/**
 * BbmJualSearch represents the model behind the search form of `app\models\BbmJual`.
 */
class BbmJualSearch extends BbmJual
{

    public $namaPerusahaan;
    public $namaBarang;
    public $namaShift;
    public $namaDispenser;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['saldoBbm']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'barang_id', 'perusahaan_id', 'shift_id', 'dispenser_id'], 'integer'],
            [['tanggal', 'created','namaPerusahaan','namaBarang','namaShift','namaDispenser','saldoBbm'], 'safe'],
            [['stok_awal', 'stok_akhir','saldoBbm'], 'number'],
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

    public function searchBy($params)
    {
        $query = BbmJual::find();
        
        // add conditions that should always apply here

        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        // ]);

       
        // grid filtering conditions
        $query->where(['tanggal'=>$params['tanggal']]);
        $query->andWhere(['barang_id'=>$params['barang_id']]);
        $query->andWhere(['dispenser_id'=>$params['dispenser_id']]);
        $query->andWhere(['shift_id'=>$params['shift_id']]);

        return $query->one();
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
        $query = BbmJual::find()->select('bbm_jual.*, (`stok_akhir` - `stok_awal`) AS `saldoBbm`');
        $query->joinWith(['perusahaan as perusahaan','barang as barang','shift','dispenser as dispenser']);
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

        $dataProvider->sort->attributes['namaDispenser'] = [
            'asc' => ['dispenser.nama'=>SORT_ASC],
            'desc' => ['dispenser.nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaShift'] = [
            'asc' => ['shift.nama'=>SORT_ASC],
            'desc' => ['shift.nama'=>SORT_DESC]
        ];

         $dataProvider->sort->attributes['saldoBbm'] = [
            'asc' => ['saldoBbm' => SORT_ASC],
            'desc' => ['saldoBbm' => SORT_DESC],
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
            'tanggal' => $this->tanggal,
            'barang_id' => $this->barang_id,
            'created' => $this->created,
            'perusahaan_id' => $this->perusahaan_id,
            'shift_id' => $this->shift_id,
            'dispenser_id' => $this->dispenser_id,
            'stok_awal' => $this->stok_awal,
            'stok_akhir' => $this->stok_akhir,
        ]);

        $query->andFilterWhere(['like', 'barang.nama_barang', $this->namaBarang])
            ->andFilterWhere(['like', 'perusahaan.nama', $this->namaPerusahaan])
            ->andFilterWhere(['like', 'shift.nama', $this->namaShift])
            ->andFilterWhere(['like', 'dispenser.nama', $this->namaDispenser]);

        if (is_numeric($this->saldoBbm)) {
            $query->having([
                'saldoBbm' => $this->saldoBbm,
            ]);
        }


        return $dataProvider;
    }
}
