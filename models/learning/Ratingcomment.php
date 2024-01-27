<?php

namespace app\models\learning;

use Yii;

/**
 * This is the model class for table "ratingcomment".
 *
 * @property int $id
 * @property string|null $userId
 * @property int|null $rating
 * @property string|null $comment
 * @property string|null $createdAt
 * @property string|null $updatedAt
 */
class Ratingcomment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ratingcomment';
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
            [['rating'], 'integer'],
            [['comment'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['userId'], 'string', 'max' => 255],
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
            'rating' => Yii::t('app', 'Rating'),
            'comment' => Yii::t('app', 'Comment'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return RatingcommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RatingcommentQuery(get_called_class());
    }
}
