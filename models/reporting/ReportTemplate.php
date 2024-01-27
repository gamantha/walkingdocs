<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "report_template".
 *
 * @property int $id
 * @property string|null $template_name
 * @property string|null $template_category
 * @property string|null $frequency_period
 * @property string|null $template_code
 *
 * @property Report[] $reports
 */
class ReportTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report_template';
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
            [['template_name', 'template_category', 'frequency_period', 'template_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'template_name' => Yii::t('app', 'Template Name'),
            'template_category' => Yii::t('app', 'Template Category'),
            'frequency_period' => Yii::t('app', 'Frequency Period'),
            'template_code' => Yii::t('app', 'Template Code'),
        ];
    }

    /**
     * Gets query for [[Reports]].
     *
     * @return \yii\db\ActiveQuery|ReportQuery
     */
    public function getReports()
    {
        return $this->hasMany(Report::className(), ['report_template_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return ReportTemplateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportTemplateQuery(get_called_class());
    }
}
