<?php

namespace app\models\pcare;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pcare\Antrean;

/**
 * AntreanSearch represents the model behind the search form of `app\models\pcare\Antrean`.
 */
class AntreanSearch extends Antrean
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['noKartu', 'nik', 'clinicId', 'tanggalPeriksa', 'kdPoli', 'nmPoli', 'noAntrean', 'angkaAntrean', 'antreanPanggil', 'keterangan', 'status'], 'safe'],
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
        $query = Antrean::find();

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
            'tanggalPeriksa' => $this->tanggalPeriksa,
        ]);

        $query->andFilterWhere(['like', 'noKartu', $this->noKartu])
            ->andFilterWhere(['like', 'nik', $this->nik])
            ->andFilterWhere(['like', 'clinicId', $this->clinicId])
            ->andFilterWhere(['like', 'kdPoli', $this->kdPoli])
            ->andFilterWhere(['like', 'nmPoli', $this->nmPoli])
            ->andFilterWhere(['like', 'noAntrean', $this->noAntrean])
            ->andFilterWhere(['like', 'angkaAntrean', $this->angkaAntrean])
            ->andFilterWhere(['like', 'antreanPanggil', $this->antreanPanggil])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
