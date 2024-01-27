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
            [['id', 'report_template_id', 'facility_id'], 'integer'],
            [['report_name', 'author_name', 'report_date', 'report_period', 'meta', 'created_at', 'modified_at'], 'safe'],
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
            'facility_id' => $this->facility_id,
            'report_date' => $this->report_date,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'report_name', $this->report_name])
            ->andFilterWhere(['like', 'author_name', $this->author_name])
            ->andFilterWhere(['like', 'report_period', $this->report_period])
            ->andFilterWhere(['like', 'meta', $this->meta]);

        return $dataProvider;
    }
}
