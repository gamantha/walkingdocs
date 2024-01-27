<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Cachebyconsid]].
 *
 * @see Cachebyconsid
 */
class CachebyconsidQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Cachebyconsid[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Cachebyconsid|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
