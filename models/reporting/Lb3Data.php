<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb3_data".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $indicator_id
 * @property int|null $value
 */
class Lb3Data extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb3_data';
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
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return Lb3DataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Lb3DataQuery(get_called_class());
    }

    /**
     * Gets query for [[Indicator]].
     *
     * @return \yii\db\ActiveQuery|Lb3IndicatorQuery
     */
    public function getIndicator()
    {
        return $this->hasOne(Lb3Indicator::className(), ['id' => 'indicator_id']);
    }


}
