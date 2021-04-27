<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[ClinicUser]].
 *
 * @see ClinicUser
 */
class ClinicUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClinicUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClinicUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
