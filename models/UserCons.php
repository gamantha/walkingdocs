<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_cons".
 *
 * @property int $userid
 * @property int $consid
 * @property string $status
 */
class UserCons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_cons';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userid', 'consid'], 'required'],
            [['userid', 'consid'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['userid', 'consid'], 'unique', 'targetAttribute' => ['userid', 'consid']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'userid' => Yii::t('app', 'Userid'),
            'consid' => Yii::t('app', 'Consid'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return UserConsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserConsQuery(get_called_class());
    }
}
