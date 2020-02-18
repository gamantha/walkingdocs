<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb3_indicator".
 *
 * @property int $id
 * @property string|null $indicator_name
 * @property string|null $indicator_category
 * @property string|null $display_text
 * @property string|null $display_text_alt
 * @property string|null $code
 */
class Lb3Indicator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb3_indicator';
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
            [['indicator_name', 'indicator_category', 'display_text', 'display_text_alt', 'code'], 'string', 'max' => 255],
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
            'indicator_category' => Yii::t('app', 'Indicator Category'),
            'display_text' => Yii::t('app', 'Display Text'),
            'display_text_alt' => Yii::t('app', 'Display Text Alt'),
            'code' => Yii::t('app', 'Code'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return Lb3IndicatorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Lb3IndicatorQuery(get_called_class());
    }
}
