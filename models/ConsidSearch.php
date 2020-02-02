<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Consid;

/**
 * ConsidSearch represents the model behind the search form of `app\models\Consid`.
 */
class ConsidSearch extends Consid
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['wd_id', 'cons_id'], 'safe'],
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
        $query = Consid::find();

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
        $query->andFilterWhere(['like', 'wd_id', $this->wd_id])
            ->andFilterWhere(['like', 'cons_id', $this->cons_id]);

        return $dataProvider;
    }
}
