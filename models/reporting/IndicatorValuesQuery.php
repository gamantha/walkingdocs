<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[IndicatorValues]].
 *
 * @see IndicatorValues
 */
class IndicatorValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IndicatorValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IndicatorValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
