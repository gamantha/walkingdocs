<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "clinic_info".
 *
 * @property string $clinicId
 * @property string|null $wilayah
 * @property string|null $kantorcabang
 * @property string|null $meta
 *
 * @property Consid $clinic
 */
class ClinicInfo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clinicId'], 'required'],
            [['meta'], 'string'],
            [['clinicId', 'wilayah', 'kantorcabang'], 'string', 'max' => 255],
            [['clinicId'], 'unique'],
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
            'wilayah' => Yii::t('app', 'Wilayah'),
            'kantorcabang' => Yii::t('app', 'Kantorcabang'),
            'meta' => Yii::t('app', 'Meta'),
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
     * @return ClinicInfoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClinicInfoQuery(get_called_class());
    }
}
