<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[Lb1Indicator]].
 *
 * @see Lb1Indicator
 */
class Lb1IndicatorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lb1Indicator[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lb1Indicator|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
