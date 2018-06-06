<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\APasien;

/**
 * APasienSearch represents the model behind the search form of `app\models\APasien`.
 */
class APasienSearch extends APasien
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NoMedrec', 'KodeKec', 'BeratLahir', 'KodeGol', 'NoMedrecLama', 'KodePisa'], 'integer'],
            [['NAMA', 'ALAMAT', 'TMPLAHIR', 'TGLLAHIR', 'PEKERJAAN', 'AGAMA', 'JENSKEL', 'GOLDARAH', 'TELP', 'JENISIDENTITAS', 'NOIDENTITAS', 'STATUSPERKAWINAN', 'Desa', 'TglInput', 'JamInput', 'AlmIp', 'NoKpst', 'KdPPK', 'NamaOrtu', 'NamaSuamiIstri'], 'safe'],
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
        $query = APasien::find();

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
            'NoMedrec' => $this->NoMedrec,
            'KodeKec' => $this->KodeKec,
            'TGLLAHIR' => $this->TGLLAHIR,
            'BeratLahir' => $this->BeratLahir,
            'KodeGol' => $this->KodeGol,
            'TglInput' => $this->TglInput,
            'JamInput' => $this->JamInput,
            'NoMedrecLama' => $this->NoMedrecLama,
            'KodePisa' => $this->KodePisa,
        ]);

        $query->andFilterWhere(['like', 'NAMA', $this->NAMA])
            ->andFilterWhere(['like', 'ALAMAT', $this->ALAMAT])
            ->andFilterWhere(['like', 'TMPLAHIR', $this->TMPLAHIR])
            ->andFilterWhere(['like', 'PEKERJAAN', $this->PEKERJAAN])
            ->andFilterWhere(['like', 'AGAMA', $this->AGAMA])
            ->andFilterWhere(['like', 'JENSKEL', $this->JENSKEL])
            ->andFilterWhere(['like', 'GOLDARAH', $this->GOLDARAH])
            ->andFilterWhere(['like', 'TELP', $this->TELP])
            ->andFilterWhere(['like', 'JENISIDENTITAS', $this->JENISIDENTITAS])
            ->andFilterWhere(['like', 'NOIDENTITAS', $this->NOIDENTITAS])
            ->andFilterWhere(['like', 'STATUSPERKAWINAN', $this->STATUSPERKAWINAN])
            ->andFilterWhere(['like', 'Desa', $this->Desa])
            ->andFilterWhere(['like', 'AlmIp', $this->AlmIp])
            ->andFilterWhere(['like', 'NoKpst', $this->NoKpst])
            ->andFilterWhere(['like', 'KdPPK', $this->KdPPK])
            ->andFilterWhere(['like', 'NamaOrtu', $this->NamaOrtu])
            ->andFilterWhere(['like', 'NamaSuamiIstri', $this->NamaSuamiIstri]);

        return $dataProvider;
    }
}
