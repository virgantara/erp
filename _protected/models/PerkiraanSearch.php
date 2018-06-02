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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent', 'perusahaan_id'], 'integer'],
            [['kode', 'nama'], 'safe'],
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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $session = Yii::$app->session;
        $userPt = '';
            
        
        if($session->isActive)
        {
            $userLevel = $session->get('level');    
            
            if($userLevel == 'admin'){
                $userPt = $session->get('perusahaan');
                $query->andWhere(['perusahaan_id'=>$userPt]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'parent' => $this->parent,
            'perusahaan_id' => $this->perusahaan_id,
        ]);

        $query->orderBy(['kode'=>'ASC']);

        // grid filtering conditions
        

        $query->andFilterWhere(['like', 'kode', $this->kode])
            ->andFilterWhere(['like', 'nama', $this->nama]);

        return $dataProvider;
    }
}
