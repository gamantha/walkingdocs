<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "wd_passed_values".
 *
 * @property int $id
 * @property int|null $registrationId
 * @property string|null $wdVisitId
 * @property string|null $clinicId
 * @property string|null $doctor
 * @property string|null $checklistNames
 * @property string|null $manualDiagnoses
 * @property string|null $disposition
 * @property string|null $statusAssessment
 * @property string|null $others
 * @property string|null $sistole
 * @property string|null $diastole
 * @property string|null $tglDaftar
 * @property string|null $noKartu
 * @property string|null $kdTkp
 * @property string|null $kunjSakit
 * @property string|null $keluhan
 * @property string|null $beratBadan
 * @property string|null $tinggiBadan
 * @property string|null $respRate
 * @property string|null $heartRate
 * @property string|null $administered
 * @property string|null $prescribed
 * @property string|null $no_urut
 * @property string|null $kdPoli
 * @property string|null $kdProviderPeserta
 * @property string|null $status
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
            [['checklistNames', 'manualDiagnoses', 'others', 'keluhan', 'administered', 'prescribed'], 'string'],
            [['wdVisitId', 'clinicId', 'doctor', 'disposition', 'statusAssessment', 'sistole', 'diastole', 'tglDaftar', 'noKartu', 'kdTkp', 'kunjSakit', 'beratBadan', 'tinggiBadan', 'respRate', 'heartRate', 'no_urut', 'kdPoli', 'kdProviderPeserta', 'status'], 'string', 'max' => 255],
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
            'wdVisitId' => Yii::t('app', 'Wd Visit ID'),
            'clinicId' => Yii::t('app', 'Clinic ID'),
            'doctor' => Yii::t('app', 'Doctor'),
            'checklistNames' => Yii::t('app', 'Checklist Names'),
            'manualDiagnoses' => Yii::t('app', 'Manual Diagnoses'),
            'disposition' => Yii::t('app', 'Disposition'),
            'statusAssessment' => Yii::t('app', 'Status Assessment'),
            'others' => Yii::t('app', 'Others'),
            'sistole' => Yii::t('app', 'Sistole'),
            'diastole' => Yii::t('app', 'Diastole'),
            'tglDaftar' => Yii::t('app', 'Tgl Daftar'),
            'noKartu' => Yii::t('app', 'No Kartu'),
            'kdTkp' => Yii::t('app', 'Kd Tkp'),
            'kunjSakit' => Yii::t('app', 'Kunj Sakit'),
            'keluhan' => Yii::t('app', 'Keluhan'),
            'beratBadan' => Yii::t('app', 'Berat Badan'),
            'tinggiBadan' => Yii::t('app', 'Tinggi Badan'),
            'respRate' => Yii::t('app', 'Resp Rate'),
            'heartRate' => Yii::t('app', 'Heart Rate'),
            'administered' => Yii::t('app', 'Administered'),
            'prescribed' => Yii::t('app', 'Prescribed'),
            'no_urut' => Yii::t('app', 'No Urut'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'kdProviderPeserta' => Yii::t('app', 'Kd Provider Peserta'),
            'status' => Yii::t('app', 'Status'),
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
