<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kas;

/**
 * KasSearch represents the model behind the search form of `app\models\Kas`.
 */
class KasSearch extends Kas
{

    public $start_date;
    public $end_date;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'jenis_kas'], 'integer'],
            [['kwitansi', 'penanggung_jawab', 'keterangan', 'tanggal', 'created','start_date','end_date'], 'safe'],
            [['kas_keluar', 'kas_masuk','saldo'], 'number'],
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
    public function search($params,$uk)
    {

        $query = Kas::find()->where(['kas_besar_kecil'=>$uk]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $session = Yii::$app->session;
        $userPt = '';
            
        $where = [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'jenis_kas' => $this->jenis_kas,
            'kas_keluar' => $this->kas_keluar,
            'kas_masuk' => $this->kas_masuk,
            'saldo' => $this->saldo,
            'created' => $this->created,
            'kas_besar_kecil' => $uk
        ];

        $query->andFilterWhere(['perusahaan_id'=>Yii::$app->user->identity->perusahaan_id]);
        
        // grid filtering conditions
        $query->andFilterWhere($where);

        if(empty($this->start_date) && empty($this->end_date))
        {
            $this->start_date = date('Y-m-01');
            $this->end_date = date('Y-m-t');
        }


        $query->andFilterWhere(['between', 'tanggal', $this->start_date, $this->end_date]);
        $query->orderBy(['tanggal'=>'ASC']);
        $query->andFilterWhere(['like', 'kwitansi', $this->kwitansi])
            ->andFilterWhere(['like', 'penanggung_jawab', $this->penanggung_jawab])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }

    public function searchLabaRugi($uk,$kode)
    {
        $query = Kas::find()->where(['kas_besar_kecil'=>$uk]);
        $query->joinWith(['perkiraan as p']);

        if(empty($this->start_date) && empty($this->end_date))
        {
            $this->start_date = date('Y-m-01');
            $this->end_date = date('Y-m-t');
        }

        $query->andWhere(['LIKE','p.kode',$kode.'%',false]);
        $query->andFilterWhere(['p.perusahaan_id'=>Yii::$app->user->identity->perusahaan_id]);
        $query->andFilterWhere(['between', 'tanggal', $this->start_date, $this->end_date]);
        $query->orderBy(['tanggal'=>'ASC']);
        
        return $query->all();
    }
}
