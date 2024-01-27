<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[Lb3Values]].
 *
 * @see Lb3Values
 */
class Lb3ValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lb3Values[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lb3Values|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
