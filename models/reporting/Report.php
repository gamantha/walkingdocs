<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int|null $report_template_id
 * @property string|null $report_name
 * @property int|null $facility_id
 * @property string|null $author_name
 * @property string|null $report_date
 * @property string|null $report_period
 * @property string|null $meta
 * @property string|null $created_at
 * @property string|null $modified_at
 *
 * @property Lb1Datum[] $lb1Data
 * @property ReportTemplate $reportTemplate
 */
class Report extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'report';
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
            [['report_template_id', 'facility_id'], 'integer'],
            [['report_date', 'created_at', 'modified_at'], 'safe'],
            [['report_name', 'author_name', 'report_period', 'meta'], 'string', 'max' => 255],
            [['report_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ReportTemplate::className(), 'targetAttribute' => ['report_template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'report_template_id' => Yii::t('app', 'Report Template ID'),
            'report_name' => Yii::t('app', 'Report Name'),
            'facility_id' => Yii::t('app', 'Facility ID'),
            'author_name' => Yii::t('app', 'Author Name'),
            'report_date' => Yii::t('app', 'Report Date'),
            'report_period' => Yii::t('app', 'Report Period'),
            'meta' => Yii::t('app', 'Meta'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * Gets query for [[Lb1Data]].
     *
     * @return \yii\db\ActiveQuery|Lb1DatumQuery
     */
    public function getLb1Data()
    {
        return $this->hasMany(Lb1Datum::className(), ['report_id' => 'id']);
    }

    /**
     * Gets query for [[ReportTemplate]].
     *
     * @return \yii\db\ActiveQuery|ReportTemplateQuery
     */
    public function getReportTemplate()
    {
        return $this->hasOne(ReportTemplate::className(), ['id' => 'report_template_id']);
    }

    /**
     * {@inheritdoc}
     * @return ReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ReportQuery(get_called_class());
    }
}
