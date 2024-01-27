<?php

namespace app\models\pcare;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pcare\PcareRegistration;

/**
 * PcareRegistrationSearch represents the model behind the search form of `app\models\pcare\PcareRegistration`.
 */
class PcareRegistrationSearch extends PcareRegistration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cons_id', 'sistole', 'diastole', 'beratBadan', 'tinggiBadan', 'respRate', 'heartRate', 'rujukBalik'], 'integer'],
            [['kdProviderPeserta', 'tglDaftar', 'noKartu', 'kdPoli', 'kunjSakit', 'keluhan', 'kdTkp', 'status', 'created_at', 'modified_at'], 'safe'],
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
        $query = PcareRegistration::find();

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
            'cons_id' => $this->cons_id,
            'tglDaftar' => $this->tglDaftar,
            'sistole' => $this->sistole,
            'diastole' => $this->diastole,
            'beratBadan' => $this->beratBadan,
            'tinggiBadan' => $this->tinggiBadan,
            'respRate' => $this->respRate,
            'heartRate' => $this->heartRate,
            'rujukBalik' => $this->rujukBalik,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'kdProviderPeserta', $this->kdProviderPeserta])
            ->andFilterWhere(['like', 'noKartu', $this->noKartu])
            ->andFilterWhere(['like', 'kdPoli', $this->kdPoli])
            ->andFilterWhere(['like', 'kunjSakit', $this->kunjSakit])
            ->andFilterWhere(['like', 'keluhan', $this->keluhan])
            ->andFilterWhere(['like', 'kdTkp', $this->kdTkp])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
