<?php

namespace app\models\pcare;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\pcare\PcareVisit;

/**
 * PcareVisitSearch represents the model behind the search form of `app\models\pcare\PcareVisit`.
 */
class PcareVisitSearch extends PcareVisit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pendaftaranId'], 'integer'],
            [['noKunjungan', 'kdSadar', 'terapi', 'kdStatusPulang', 'tglPulang', 'kdDokter', 'kdDiag1', 'kdDiag2', 'kdDiag3', 'kdPoliRujukInternal', 'tglEstRujuk', 'kdppk', 'subSpesialis_kdSubSpesialis1', 'subSpesialis_kdSarana', 'khusus_kdKhusus', 'khusus_kdSubSpesialis', 'khusus_catatan', 'kdTacc', 'alasanTacc', 'json', 'status', 'created_at', 'modified_at'], 'safe'],
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
        $query = PcareVisit::find();

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
            'pendaftaranId' => $this->pendaftaranId,
            'tglPulang' => $this->tglPulang,
            'tglEstRujuk' => $this->tglEstRujuk,
            'created_at' => $this->created_at,
            'modified_at' => $this->modified_at,
        ]);

        $query->andFilterWhere(['like', 'noKunjungan', $this->noKunjungan])
            ->andFilterWhere(['like', 'kdSadar', $this->kdSadar])
            ->andFilterWhere(['like', 'terapi', $this->terapi])
            ->andFilterWhere(['like', 'kdStatusPulang', $this->kdStatusPulang])
            ->andFilterWhere(['like', 'kdDokter', $this->kdDokter])
            ->andFilterWhere(['like', 'kdDiag1', $this->kdDiag1])
            ->andFilterWhere(['like', 'kdDiag2', $this->kdDiag2])
            ->andFilterWhere(['like', 'kdDiag3', $this->kdDiag3])
            ->andFilterWhere(['like', 'kdPoliRujukInternal', $this->kdPoliRujukInternal])
            ->andFilterWhere(['like', 'kdppk', $this->kdppk])
            ->andFilterWhere(['like', 'subSpesialis_kdSubSpesialis1', $this->subSpesialis_kdSubSpesialis1])
            ->andFilterWhere(['like', 'subSpesialis_kdSarana', $this->subSpesialis_kdSarana])
            ->andFilterWhere(['like', 'khusus_kdKhusus', $this->khusus_kdKhusus])
            ->andFilterWhere(['like', 'khusus_kdSubSpesialis', $this->khusus_kdSubSpesialis])
            ->andFilterWhere(['like', 'khusus_catatan', $this->khusus_catatan])
            ->andFilterWhere(['like', 'kdTacc', $this->kdTacc])
            ->andFilterWhere(['like', 'alasanTacc', $this->alasanTacc])
            ->andFilterWhere(['like', 'json', $this->json])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
