<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Icd10]].
 *
 * @see Icd10
 */
class Icd10Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Icd10[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Icd10|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
