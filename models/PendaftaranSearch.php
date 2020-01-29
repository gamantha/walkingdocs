<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pendaftaran;

/**
 * PendaftaranSearch represents the model behind the search form of `app\models\Pendaftaran`.
 */
class PendaftaranSearch extends Pendaftaran
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['no_bpjs', 'nama', 'status_peserta', 'jenis_peserta', 'tanggal_lahir', 'kelamin', 'ppk_umum', 'no_handphone', 'no_rekam_medis', 'created_at', 'modified_at'], 'safe'],
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
        $query = Pendaftaran::find();

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
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'no_bpjs', $this->no_bpjs])
            ->andFilterWhere(['like', 'nama', $this->nama])
            ->andFilterWhere(['like', 'status_peserta', $this->status_peserta])
            ->andFilterWhere(['like', 'jenis_peserta', $this->jenis_peserta])
            ->andFilterWhere(['like', 'tanggal_lahir', $this->tanggal_lahir])
            ->andFilterWhere(['like', 'kelamin', $this->kelamin])
            ->andFilterWhere(['like', 'ppk_umum', $this->ppk_umum])
            ->andFilterWhere(['like', 'no_handphone', $this->no_handphone])
            ->andFilterWhere(['like', 'no_rekam_medis', $this->no_rekam_medis]);

        return $dataProvider;
    }
}
