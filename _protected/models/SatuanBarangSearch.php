<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\SatuanBarang;

/**
 * SatuanBarangSearch represents the model behind the search form of `app\models\SatuanBarang`.
 */
class SatuanBarangSearch extends SatuanBarang
{

    public $jenisPerusahaan;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_satuan', 'jenis'], 'integer'],
            [['kode', 'nama','jenisPerusahaan'], 'safe'],
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
        $query = SatuanBarang::find();

        // add conditions that should always apply here

        $query->joinWith('jenis0');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['jenisPerusahaan'] = [
            'asc' => ['nama'=>SORT_ASC],
            'desc' => ['nama'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

     

        $query->andFilterWhere(['like', self::tableName().'.kode', $this->kode])
            ->andFilterWhere(['like', self::tableName().'.nama', $this->nama])
            ->andFilterWhere(['like', 'perusahaan_jenis.nama', $this->jenisPerusahaan]);

        return $dataProvider;
    }
}
