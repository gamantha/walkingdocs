<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "like".
 *
 * @property string $type
 * @property string $itemId
 * @property string $userId
 * @property string|null $like
 * @property string|null $insertAt
 * @property string|null $modifiedAt
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'like';
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
            [['type', 'itemId', 'userId'], 'required'],
            [['insertAt', 'modifiedAt'], 'safe'],
            [['type', 'itemId', 'userId', 'like'], 'string', 'max' => 255],
            [['type', 'itemId', 'userId'], 'unique', 'targetAttribute' => ['type', 'itemId', 'userId']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'type' => Yii::t('app', 'Type'),
            'itemId' => Yii::t('app', 'Item ID'),
            'userId' => Yii::t('app', 'User ID'),
            'like' => Yii::t('app', 'Like'),
            'insertAt' => Yii::t('app', 'Insert At'),
            'modifiedAt' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return LikeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikeQuery(get_called_class());
    }
}
