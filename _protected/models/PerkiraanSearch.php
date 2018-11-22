<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perkiraan;

/**
 * PerkiraanSearch represents the model behind the search form of `app\models\Perkiraan`.
 */
class PerkiraanSearch extends Perkiraan
{

    public $namaParent;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'perusahaan_id'], 'integer'],
            [['kode', 'nama','namaParent'], 'safe'],
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
        $query = Perkiraan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

         $dataProvider->sort->attributes['namaParent'] = [
            'asc' => ['nama'=>SORT_ASC],
            'desc' => ['nama'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $userPt = Yii::$app->user->identity->perusahaan_id;
            
        $query->andWhere(['perusahaan_id'=>$userPt ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent' => $this->parent,
            'perusahaan_id' => $this->perusahaan_id,
        ]);

        $query->orderBy(['kode'=>'ASC']);

        // grid filtering conditions
        

        $query->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'perkiraan.nama', $this->namaParent]);

        return $dataProvider;
    }

    public function searchAkuns($params)
    {
        $query = Perkiraan::find();
        $query->where(['kode'=>$params]);
        $query->andFilterWhere(['perusahaan_id'=>Yii::$app->user->identity->perusahaan_id]);

        return $query->one();
    }

    public function searchPerkiraanByKode($kode)
    {
        $query = \app\models\Perkiraan::find();
        $query->andWhere(['LIKE','kode',$kode.'%',false]);
        $query->andFilterWhere([
            'level' => 3,
            'perusahaan_id'=>Yii::$app->user->identity->perusahaan_id
        ]);
        $query->orderBy(['kode'=>'ASC']);

        return $query->all();
    }

}
