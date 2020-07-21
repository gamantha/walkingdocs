<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "heartbeat".
 *
 * @property int $id
 * @property string|null $userId
 * @property string|null $createdAt
 * @property string|null $location
 */
class Heartbeat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'heartbeat';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('wdlearningdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createdAt'], 'safe'],
            [['userId', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'userId' => Yii::t('app', 'User ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'location' => Yii::t('app', 'Location'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return HeartbeatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HeartbeatQuery(get_called_class());
    }
}
