<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[WdPassedValues]].
 *
 * @see WdPassedValues
 */
class WdPassedValuesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return WdPassedValues[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return WdPassedValues|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
