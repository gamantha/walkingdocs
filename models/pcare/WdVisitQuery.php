<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[WdVisit]].
 *
 * @see WdVisit
 */
class WdVisitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return WdVisit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return WdVisit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
