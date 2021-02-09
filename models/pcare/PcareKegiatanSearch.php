<?php

namespace app\models\pcare;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pcare\PcareKegiatan;

/**
 * PcareKegiatanSearch represents the model behind the search form of `app\models\pcare\PcareKegiatan`.
 */
class PcareKegiatanSearch extends PcareKegiatan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'consId', 'biaya'], 'integer'],
            [['eduId', 'clubId', 'tglPelayanan', 'kdKegiatan', 'kdKelompok', 'materi', 'pembicara', 'lokasi', 'keterangan', 'status', 'created_at', 'modified_at'], 'safe'],
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
        $query = PcareKegiatan::find();

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
            'consId' => $this->consId,
            'tglPelayanan' => $this->tglPelayanan,
            'biaya' => $this->biaya,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'eduId', $this->eduId])
            ->andFilterWhere(['like', 'clubId', $this->clubId])
            ->andFilterWhere(['like', 'kdKegiatan', $this->kdKegiatan])
            ->andFilterWhere(['like', 'kdKelompok', $this->kdKelompok])
            ->andFilterWhere(['like', 'materi', $this->materi])
            ->andFilterWhere(['like', 'pembicara', $this->pembicara])
            ->andFilterWhere(['like', 'lokasi', $this->lokasi])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
