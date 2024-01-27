<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[Lb3Data]].
 *
 * @see Lb3Data
 */
class Lb3DataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lb3Data[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lb3Data|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
