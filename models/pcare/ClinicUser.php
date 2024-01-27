<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "clinic_user".
 *
 * @property int $id
 * @property string|null $clinicId
 * @property int|null $userId
 *
 * @property Consid $clinic
 * @property User $user
 */
class ClinicUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'userId'], 'integer'],
            [['clinicId'], 'string', 'max' => 255],
            [['id'], 'unique'],
            [['clinicId'], 'exist', 'skipOnError' => true, 'targetClass' => Consid::className(), 'targetAttribute' => ['clinicId' => 'wd_id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
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
            'userId' => Yii::t('app', 'User ID'),
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * {@inheritdoc}
     * @return ClinicUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClinicUserQuery(get_called_class());
    }
}
