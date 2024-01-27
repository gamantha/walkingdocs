<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[Lb3Indicator]].
 *
 * @see Lb3Indicator
 */
class Lb3IndicatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lb3Indicator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lb3Indicator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
