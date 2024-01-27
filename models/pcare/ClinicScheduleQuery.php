<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[ClinicSchedule]].
 *
 * @see ClinicSchedule
 */
class ClinicScheduleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClinicSchedule[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClinicSchedule|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
