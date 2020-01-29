<?php

namespace app\models\reporting;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\reporting\Report;

/**
 * ReportSearch represents the model behind the search form of `app\models\reporting\Report`.
 */
class ReportSearch extends Report
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'report_template_id', 'facility_id', 'author_id'], 'integer'],
            [['report_name', 'report_period', 'report_date', 'author_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = Report::find();

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
            'report_template_id' => $this->report_template_id,
            'report_date' => $this->report_date,
            'facility_id' => $this->facility_id,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'report_name', $this->report_name])
            ->andFilterWhere(['like', 'report_period', $this->report_period])
            ->andFilterWhere(['like', 'author_name', $this->author_name]);

        return $dataProvider;
    }
}
