<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb1_data".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $indicator_id
 * @property int|null $n_m_0d7d
 * @property int|null $n_f_0d7d
 * @property int|null $o_m_0d7d
 * @property int|null $o_f_0d7d
 * @property int|null $n_m_8d28d
 * @property int|null $n_f_8d28d
 * @property int|null $o_m_8d28d
 * @property int|null $o_f_8d28d
 * @property int|null $n_m_1m11m
 * @property int|null $n_f_1m11m
 * @property int|null $o_m_1m11m
 * @property int|null $o_f_1m11m
 * @property int|null $n_m_1y4y
 * @property int|null $n_f_1y4y
 * @property int|null $o_m_1y4y
 * @property int|null $o_f_1y4y
 * @property int|null $n_m_5y9y
 * @property int|null $n_f_5y9y
 * @property int|null $o_m_5y9y
 * @property int|null $o_f_5y9y
 * @property int|null $n_m_10y14y
 * @property int|null $n_f_10y14y
 * @property int|null $o_m_10y14y
 * @property int|null $o_f_10y14y
 * @property int|null $n_m_15y19y
 * @property int|null $n_f_15y19y
 * @property int|null $o_m_15y19y
 * @property int|null $o_f_15y19y
 * @property int|null $n_m_20y44y
 * @property int|null $n_f_20y44y
 * @property int|null $o_m_20y44y
 * @property int|null $o_f_20y44y
 * @property int|null $n_m_45y59y
 * @property int|null $n_f_45y59y
 * @property int|null $o_m_45y59y
 * @property int|null $o_f_45y59y
 * @property int|null $n_m_60y
 * @property int|null $n_f_60y
 * @property int|null $o_m_60y
 * @property int|null $o_f_60y
 *
 * @property Lb1Indicator $indicator
 * @property Report $report
 */
class Lb1Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb1_data';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('reportingdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'indicator_id', 'n_m_0d7d', 'n_f_0d7d', 'o_m_0d7d', 'o_f_0d7d', 'n_m_8d28d', 'n_f_8d28d', 'o_m_8d28d', 'o_f_8d28d', 'n_m_1m11m', 'n_f_1m11m', 'o_m_1m11m', 'o_f_1m11m', 'n_m_1y4y', 'n_f_1y4y', 'o_m_1y4y', 'o_f_1y4y', 'n_m_5y9y', 'n_f_5y9y', 'o_m_5y9y', 'o_f_5y9y', 'n_m_10y14y', 'n_f_10y14y', 'o_m_10y14y', 'o_f_10y14y', 'n_m_15y19y', 'n_f_15y19y', 'o_m_15y19y', 'o_f_15y19y', 'n_m_20y44y', 'n_f_20y44y', 'o_m_20y44y', 'o_f_20y44y', 'n_m_45y59y', 'n_f_45y59y', 'o_m_45y59y', 'o_f_45y59y', 'n_m_60y', 'n_f_60y', 'o_m_60y', 'o_f_60y'], 'integer'],
            [['indicator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lb1Indicator::className(), 'targetAttribute' => ['indicator_id' => 'id']],
            [['report_id'], 'exist', 'skipOnError' => true, 'targetClass' => Report::className(), 'targetAttribute' => ['report_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'report_id' => Yii::t('app', 'Report ID'),
            'indicator_id' => Yii::t('app', 'Indicator ID'),
            'n_m_0d7d' => Yii::t('app', 'N M 0d7d'),
            'n_f_0d7d' => Yii::t('app', 'N F 0d7d'),
            'o_m_0d7d' => Yii::t('app', 'O M 0d7d'),
            'o_f_0d7d' => Yii::t('app', 'O F 0d7d'),
            'n_m_8d28d' => Yii::t('app', 'N M 8d28d'),
            'n_f_8d28d' => Yii::t('app', 'N F 8d28d'),
            'o_m_8d28d' => Yii::t('app', 'O M 8d28d'),
            'o_f_8d28d' => Yii::t('app', 'O F 8d28d'),
            'n_m_1m11m' => Yii::t('app', 'N M 1m11m'),
            'n_f_1m11m' => Yii::t('app', 'N F 1m11m'),
            'o_m_1m11m' => Yii::t('app', 'O M 1m11m'),
            'o_f_1m11m' => Yii::t('app', 'O F 1m11m'),
            'n_m_1y4y' => Yii::t('app', 'N M 1y4y'),
            'n_f_1y4y' => Yii::t('app', 'N F 1y4y'),
            'o_m_1y4y' => Yii::t('app', 'O M 1y4y'),
            'o_f_1y4y' => Yii::t('app', 'O F 1y4y'),
            'n_m_5y9y' => Yii::t('app', 'N M 5y9y'),
            'n_f_5y9y' => Yii::t('app', 'N F 5y9y'),
            'o_m_5y9y' => Yii::t('app', 'O M 5y9y'),
            'o_f_5y9y' => Yii::t('app', 'O F 5y9y'),
            'n_m_10y14y' => Yii::t('app', 'N M 10y14y'),
            'n_f_10y14y' => Yii::t('app', 'N F 10y14y'),
            'o_m_10y14y' => Yii::t('app', 'O M 10y14y'),
            'o_f_10y14y' => Yii::t('app', 'O F 10y14y'),
            'n_m_15y19y' => Yii::t('app', 'N M 15y19y'),
            'n_f_15y19y' => Yii::t('app', 'N F 15y19y'),
            'o_m_15y19y' => Yii::t('app', 'O M 15y19y'),
            'o_f_15y19y' => Yii::t('app', 'O F 15y19y'),
            'n_m_20y44y' => Yii::t('app', 'N M 20y44y'),
            'n_f_20y44y' => Yii::t('app', 'N F 20y44y'),
            'o_m_20y44y' => Yii::t('app', 'O M 20y44y'),
            'o_f_20y44y' => Yii::t('app', 'O F 20y44y'),
            'n_m_45y59y' => Yii::t('app', 'N M 45y59y'),
            'n_f_45y59y' => Yii::t('app', 'N F 45y59y'),
            'o_m_45y59y' => Yii::t('app', 'O M 45y59y'),
            'o_f_45y59y' => Yii::t('app', 'O F 45y59y'),
            'n_m_60y' => Yii::t('app', 'N M 60y'),
            'n_f_60y' => Yii::t('app', 'N F 60y'),
            'o_m_60y' => Yii::t('app', 'O M 60y'),
            'o_f_60y' => Yii::t('app', 'O F 60y'),
        ];
    }

    /**
     * Gets query for [[Indicator]].
     *
     * @return \yii\db\ActiveQuery|Lb1IndicatorQuery
     */
    public function getIndicator()
    {
        return $this->hasOne(Lb1Indicator::className(), ['id' => 'indicator_id']);
    }

    /**
     * Gets query for [[Report]].
     *
     * @return \yii\db\ActiveQuery|ReportQuery
     */
    public function getReport()
    {
        return $this->hasOne(Report::className(), ['id' => 'report_id']);
    }

    /**
     * {@inheritdoc}
     * @return Lb1DataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Lb1DataQuery(get_called_class());
    }
}
