<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[ClinicInfo]].
 *
 * @see ClinicInfo
 */
class ClinicInfoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClinicInfo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClinicInfo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
