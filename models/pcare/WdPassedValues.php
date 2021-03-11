<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "wd_passed_values".
 *
 * @property int $id
 * @property int|null $registrationId
 * @property string|null $doctor
 * @property string|null $checklistNames
 * @property string|null $manualDiagnoses
 * @property string|null $disposition
 * @property string|null $statusAssessment
 * @property string|null $others
 *
 * @property PcareRegistration $registration
 */
class WdPassedValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wd_passed_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registrationId'], 'integer'],
            [['checklistNames', 'manualDiagnoses', 'others'], 'string'],
            [['doctor', 'disposition', 'statusAssessment'], 'string', 'max' => 255],
            [['registrationId'], 'exist', 'skipOnError' => true, 'targetClass' => PcareRegistration::className(), 'targetAttribute' => ['registrationId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'registrationId' => Yii::t('app', 'Registration ID'),
            'doctor' => Yii::t('app', 'Doctor'),
            'checklistNames' => Yii::t('app', 'Checklist Names'),
            'manualDiagnoses' => Yii::t('app', 'Manual Diagnoses'),
            'disposition' => Yii::t('app', 'Disposition'),
            'statusAssessment' => Yii::t('app', 'Status Assessment'),
            'others' => Yii::t('app', 'Others'),
        ];
    }

    /**
     * Gets query for [[Registration]].
     *
     * @return \yii\db\ActiveQuery|PcareRegistrationQuery
     */
    public function getRegistration()
    {
        return $this->hasOne(PcareRegistration::className(), ['id' => 'registrationId']);
    }

    /**
     * {@inheritdoc}
     * @return WdPassedValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WdPassedValuesQuery(get_called_class());
    }
}
