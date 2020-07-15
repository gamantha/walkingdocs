<?php

namespace app\models\learning;

/**
 * This is the ActiveQuery class for [[Ratingcomment]].
 *
 * @see Ratingcomment
 */
class RatingcommentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Ratingcomment[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Ratingcomment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
