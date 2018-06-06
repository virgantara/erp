<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TrRawatInap;

/**
 * TrRawatInapSearch represents the model behind the search form of `app\models\TrRawatInap`.
 */
class TrRawatInapSearch extends TrRawatInap
{

    public $namaPasien;
    public $namaKamar;
    public $namaDokter;
    public $noRM;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rawat_inap', 'kode_rawat', 'pasien_id', 'jenis_pasien', 'kamar_id', 'dokter_id', 'status_inap', 'status_rawat', 'prev_kamar', 'next_kamar', 'status_pasien', 'is_naik_kelas'], 'integer'],
            [['tanggal_masuk', 'jam_masuk', 'tanggal_keluar', 'jam_keluar', 'datetime_masuk', 'datetime_keluar', 'created', 'datetime_masuk_ird', 'tanggal_masuk_ird', 'jam_masuk_ird', 'datetime_keluar_ird', 'tanggal_keluar_ird', 'jam_keluar_ird', 'tanggal_pulang', 'jam_pulang', 'datetime_pulang', 'jenis_ird','namaPasien','namaKamar','noRM'], 'safe'],
            [['biaya_paket_1', 'biaya_paket_2', 'biaya_paket_3', 'biaya_total_kamar', 'biaya_total_ird', 'biaya_dibayar', 'biaya_kamar'], 'number'],
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
        $query = TrRawatInap::find()->where(['status_pasien'=>1]);
         $query->joinWith(['pasien as p','kamar as k']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['namaPasien'] = [
            'asc' => ['p.NAMA'=>SORT_ASC],
            'desc' => ['p.NAMA'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['namaKamar'] = [
            'asc' => ['k.nama_kamar'=>SORT_ASC],
            'desc' => ['k.nama_kamar'=>SORT_DESC]
        ];

        $dataProvider->sort->attributes['noRM'] = [
            'asc' => ['pasien_id'=>SORT_ASC],
            'desc' => ['pasien_id'=>SORT_DESC]
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_rawat_inap' => $this->id_rawat_inap,
            'kode_rawat' => $this->kode_rawat,
            'tanggal_masuk' => $this->tanggal_masuk,
            'jam_masuk' => $this->jam_masuk,
            'tanggal_keluar' => $this->tanggal_keluar,
            'jam_keluar' => $this->jam_keluar,
            'datetime_masuk' => $this->datetime_masuk,
            'datetime_keluar' => $this->datetime_keluar,
            'created' => $this->created,
            'pasien_id' => $this->pasien_id,
            'jenis_pasien' => $this->jenis_pasien,
            'kamar_id' => $this->kamar_id,
            'dokter_id' => $this->dokter_id,
            'biaya_paket_1' => $this->biaya_paket_1,
            'biaya_paket_2' => $this->biaya_paket_2,
            'biaya_paket_3' => $this->biaya_paket_3,
            'status_inap' => $this->status_inap,
            'status_rawat' => $this->status_rawat,
            'datetime_masuk_ird' => $this->datetime_masuk_ird,
            'tanggal_masuk_ird' => $this->tanggal_masuk_ird,
            'jam_masuk_ird' => $this->jam_masuk_ird,
            'datetime_keluar_ird' => $this->datetime_keluar_ird,
            'tanggal_keluar_ird' => $this->tanggal_keluar_ird,
            'jam_keluar_ird' => $this->jam_keluar_ird,
            'tanggal_pulang' => $this->tanggal_pulang,
            'jam_pulang' => $this->jam_pulang,
            'datetime_pulang' => $this->datetime_pulang,
            'prev_kamar' => $this->prev_kamar,
            'next_kamar' => $this->next_kamar,
            'is_naik_kelas' => $this->is_naik_kelas,
            'biaya_total_kamar' => $this->biaya_total_kamar,
            'biaya_total_ird' => $this->biaya_total_ird,
            'biaya_dibayar' => $this->biaya_dibayar,
            'biaya_kamar' => $this->biaya_kamar,
           
        ]);

        $query->andFilterWhere(['like', 'p.NAMA', $this->namaPasien])
        ->andFilterWhere(['like', 'k.nama_kamar', $this->namaKamar])
        ->andFilterWhere(['like', 'pasien_id', $this->noRM]);
        
        $query->orderBy('datetime_masuk DESC');

        return $dataProvider;
    }
}
