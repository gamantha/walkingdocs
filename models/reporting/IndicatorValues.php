<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "indicator_values".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $indicator_id
 * @property string|null $indicator_name
 * @property string|null $gender
 * @property string|null $age_range
 * @property int|null $value
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class IndicatorValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'indicator_values';
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
            [['report_id', 'indicator_id', 'value'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['indicator_name', 'gender', 'age_range'], 'string', 'max' => 255],
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
            'indicator_name' => Yii::t('app', 'Indicator Name'),
            'gender' => Yii::t('app', 'Gender'),
            'age_range' => Yii::t('app', 'Age Range'),
            'value' => Yii::t('app', 'Value'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return IndicatorValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IndicatorValuesQuery(get_called_class());
    }
}
