<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\RequestOrderIn;

/**
 * RequestOrderInSearch represents the model behind the search form of `app\models\RequestOrderIn`.
 */
class RequestOrderInSearch extends RequestOrderIn
{

    public $namaSender;
    public $noRo;
    public $tanggalPengajuan;
    public $tanggalPenyetujuan;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'perusahaan_id', 'departemen_id', 'ro_id'], 'integer'],
            [['created','namaSender','noRo','tanggalPengajuan','tanggalPenyetujuan'], 'safe'],
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
        $query = RequestOrderIn::find();

        $query->where([self::tableName().'.departemen_id'=>Yii::$app->user->identity->departemen]);

        $query->joinWith(['ro as ro','ro.departemen as d']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->sort->attributes['namaSender'] = [
            'asc' => ['nama'=>SORT_ASC],
            'desc' => ['nama'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['noRo'] = [
            'asc' => ['no_ro'=>SORT_ASC],
            'desc' => ['no_ro'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['tanggalPengajuan'] = [
            'asc' => ['ro.tanggal_pengajuan'=>SORT_ASC],
            'desc' => ['ro.tanggal_pengajuan'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['tanggalPenyetujuan'] = [
            'asc' => ['ro.tanggal_penyetujuan'=>SORT_ASC],
            'desc' => ['ro.tanggal_penyetujuan'=>SORT_DESC]
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
            'perusahaan_id' => $this->perusahaan_id,
            'departemen_id' => $this->departemen_id,
            'ro_id' => $this->ro_id,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'd.nama', $this->namaSender]);
        $query->andFilterWhere(['like', 'ro.tanggal_pengajuan', $this->tanggalPengajuan]);
        $query->andFilterWhere(['like', 'ro.tanggal_penyetujuan', $this->tanggalPenyetujuan]);
        $query->andFilterWhere(['like', 'ro.no_ro', $this->noRo]);

        return $dataProvider;
    }
}
