<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "report".
 *
 * @property int $id
 * @property int|null $report_template_id
 * @property string|null $report_name
 * @property string|null $report_period
 * @property string|null $report_date
 * @property int|null $facility_id
 * @property int|null $author_id
 * @property string|null $author_name
 * @property string|null $created_at
 * @property string|null $updated_at
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
            [['report_template_id', 'facility_id', 'author_id'], 'integer'],
            [['report_date', 'created_at', 'updated_at'], 'safe'],
            [['report_name', 'report_period', 'author_name'], 'string', 'max' => 255],
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
            'report_period' => Yii::t('app', 'Report Period'),
            'report_date' => Yii::t('app', 'Report Date'),
            'facility_id' => Yii::t('app', 'Facility ID'),
            'author_id' => Yii::t('app', 'Author ID'),
            'author_name' => Yii::t('app', 'Author Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
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
