<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[IndicatorDictionary]].
 *
 * @see IndicatorDictionary
 */
class IndicatorDictionaryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return IndicatorDictionary[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return IndicatorDictionary|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
