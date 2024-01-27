<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[PcareVisit]].
 *
 * @see PcareVisit
 */
class PcareVisitQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PcareVisit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PcareVisit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
