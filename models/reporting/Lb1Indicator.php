<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb1_indicator".
 *
 * @property int $id
 * @property string|null $indicator_name
 * @property string|null $category
 * @property string|null $display_text
 * @property string|null $display_text_alt
 * @property string|null $code
 * @property string|null $icd10
 *
 * @property Lb1Datum[] $lb1Data
 */
class Lb1Indicator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb1_indicator';
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
            [['indicator_name', 'category', 'display_text', 'display_text_alt', 'code', 'icd10'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'indicator_name' => Yii::t('app', 'Indicator Name'),
            'category' => Yii::t('app', 'Category'),
            'display_text' => Yii::t('app', 'Display Text'),
            'display_text_alt' => Yii::t('app', 'Display Text Alt'),
            'code' => Yii::t('app', 'Code'),
            'icd10' => Yii::t('app', 'Icd10'),
        ];
    }

    /**
     * Gets query for [[Lb1Data]].
     *
     * @return \yii\db\ActiveQuery|Lb1DatumQuery
     */
    public function getLb1Data()
    {
        return $this->hasMany(Lb1Datum::className(), ['indicator_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return Lb1IndicatorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Lb1IndicatorQuery(get_called_class());
    }
}
