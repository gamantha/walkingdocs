<?php

namespace app\models\learning;

/**
 * This is the ActiveQuery class for [[ToolCalculation]].
 *
 * @see ToolCalculation
 */
class ToolCalculationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ToolCalculation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ToolCalculation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
