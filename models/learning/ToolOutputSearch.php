<?php

namespace app\models\learning;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\learning\ToolOutput;

/**
 * ToolOutputSearch represents the model behind the search form of `app\models\learning\ToolOutput`.
 */
class ToolOutputSearch extends ToolOutput
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tool_id'], 'integer'],
            [['output_name', 'output_type'], 'safe'],
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
        $query = ToolOutput::find();

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
            'tool_id' => $this->tool_id,
        ]);

        $query->andFilterWhere(['like', 'output_name', $this->output_name])
            ->andFilterWhere(['like', 'output_type', $this->output_type]);

        return $dataProvider;
    }
}
