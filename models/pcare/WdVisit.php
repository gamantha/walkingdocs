<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "wd_visit".
 *
 * @property int $id
 * @property string|null $clinicId
 * @property string|null $visitId
 * @property string|null $status
 * @property string|null $json
 * @property string|null $payload
 */
class WdVisit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wd_visit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['json', 'payload'], 'string'],
            [['clinicId', 'visitId', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'clinicId' => Yii::t('app', 'Clinic ID'),
            'visitId' => Yii::t('app', 'Visit ID'),
            'status' => Yii::t('app', 'Status'),
            'json' => Yii::t('app', 'Json'),
            'payload' => Yii::t('app', 'Payload'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return WdVisitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new WdVisitQuery(get_called_class());
    }
}
