<?php

namespace app\models\pcare;

use app\models\Consid;
use app\models\ConsidQuery;
use Yii;

/**
 * This is the model class for table "clinic_schedule".
 *
 * @property string $clinicId
 * @property string $kdPoli
 * @property string|null $nmPoli
 * @property string $dayofweek
 * @property string $starttime
 * @property string $endtime
 * @property string|null $status
 *
 * @property Consid $clinic
 */
class ClinicSchedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clinicId', 'kdPoli', 'dayofweek', 'starttime', 'endtime'], 'required'],
            [['starttime', 'endtime'], 'safe'],
            [['clinicId', 'kdPoli', 'nmPoli', 'dayofweek', 'status'], 'string', 'max' => 255],
            [['clinicId', 'kdPoli', 'dayofweek', 'starttime', 'endtime'], 'unique', 'targetAttribute' => ['clinicId', 'kdPoli', 'dayofweek', 'starttime', 'endtime']],
            [['clinicId'], 'exist', 'skipOnError' => true, 'targetClass' => Consid::className(), 'targetAttribute' => ['clinicId' => 'wd_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'clinicId' => Yii::t('app', 'Clinic ID'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'nmPoli' => Yii::t('app', 'Nm Poli'),
            'dayofweek' => Yii::t('app', 'Dayofweek'),
            'starttime' => Yii::t('app', 'Starttime'),
            'endtime' => Yii::t('app', 'Endtime'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Clinic]].
     *
     * @return \yii\db\ActiveQuery|ConsidQuery
     */
    public function getClinic()
    {
        return $this->hasOne(Consid::className(), ['wd_id' => 'clinicId']);
    }

    /**
     * {@inheritdoc}
     * @return ClinicScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClinicScheduleQuery(get_called_class());
    }
}
