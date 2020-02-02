<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kunjungan;

/**
 * KunjunganSearch represents the model behind the search form of `app\models\Kunjungan`.
 */
class KunjunganSearch extends Kunjungan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pendaftaran_id'], 'integer'],
            [['jenis_kunjungan', 'perawatan', 'poli_tujuan', 'keluhan'], 'safe'],
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
        $query = Kunjungan::find();

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
            'pendaftaran_id' => $this->pendaftaran_id,
        ]);

        $query->andFilterWhere(['like', 'jenis_kunjungan', $this->jenis_kunjungan])
            ->andFilterWhere(['like', 'perawatan', $this->perawatan])
            ->andFilterWhere(['like', 'poli_tujuan', $this->poli_tujuan])
            ->andFilterWhere(['like', 'keluhan', $this->keluhan]);

        return $dataProvider;
    }
}
