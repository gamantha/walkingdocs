<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb1_data".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $indicator_id
 * @property int|null $m_0d7d
 * @property int|null $f_0d7d
 * @property int|null $m_8d28d
 * @property int|null $f_8d28d
 * @property int|null $m_1m1y
 * @property int|null $f_1m1y
 * @property int|null $m_1y4y
 * @property int|null $f_1y4y
 * @property int|null $m_5y9y
 * @property int|null $f_5y9y
 * @property int|null $m_10y14y
 * @property int|null $f_10y14y
 * @property int|null $m_15y19y
 * @property int|null $f_15y19y
 * @property int|null $m_20y44y
 * @property int|null $f_20y44y
 * @property int|null $m_45y54y
 * @property int|null $f_45y54y
 * @property int|null $m_55y59y
 * @property int|null $f_55y59y
 * @property int|null $m_60y69y
 * @property int|null $f_60y69y
 * @property int|null $m_70y
 * @property int|null $f_70y
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
            [['report_id', 'indicator_id', 'm_0d7d', 'f_0d7d', 'm_8d28d', 'f_8d28d', 'm_1m1y', 'f_1m1y', 'm_1y4y', 'f_1y4y', 'm_5y9y', 'f_5y9y', 'm_10y14y', 'f_10y14y', 'm_15y19y', 'f_15y19y', 'm_20y44y', 'f_20y44y', 'm_45y54y', 'f_45y54y', 'm_55y59y', 'f_55y59y', 'm_60y69y', 'f_60y69y', 'm_70y', 'f_70y'], 'integer'],
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
            'm_0d7d' => Yii::t('app', 'M 0d7d'),
            'f_0d7d' => Yii::t('app', 'F 0d7d'),
            'm_8d28d' => Yii::t('app', 'M 8d28d'),
            'f_8d28d' => Yii::t('app', 'F 8d28d'),
            'm_1m1y' => Yii::t('app', 'M 1m1y'),
            'f_1m1y' => Yii::t('app', 'F 1m1y'),
            'm_1y4y' => Yii::t('app', 'M 1y4y'),
            'f_1y4y' => Yii::t('app', 'F 1y4y'),
            'm_5y9y' => Yii::t('app', 'M 5y9y'),
            'f_5y9y' => Yii::t('app', 'F 5y9y'),
            'm_10y14y' => Yii::t('app', 'M 10y14y'),
            'f_10y14y' => Yii::t('app', 'F 10y14y'),
            'm_15y19y' => Yii::t('app', 'M 15y19y'),
            'f_15y19y' => Yii::t('app', 'F 15y19y'),
            'm_20y44y' => Yii::t('app', 'M 20y44y'),
            'f_20y44y' => Yii::t('app', 'F 20y44y'),
            'm_45y54y' => Yii::t('app', 'M 45y54y'),
            'f_45y54y' => Yii::t('app', 'F 45y54y'),
            'm_55y59y' => Yii::t('app', 'M 55y59y'),
            'f_55y59y' => Yii::t('app', 'F 55y59y'),
            'm_60y69y' => Yii::t('app', 'M 60y69y'),
            'f_60y69y' => Yii::t('app', 'F 60y69y'),
            'm_70y' => Yii::t('app', 'M 70y'),
            'f_70y' => Yii::t('app', 'F 70y'),
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
