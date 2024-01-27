<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[UserCons]].
 *
 * @see UserCons
 */
class UserConsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserCons[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserCons|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
