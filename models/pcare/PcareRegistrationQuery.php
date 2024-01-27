<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[PcareRegistration]].
 *
 * @see PcareRegistration
 */
class PcareRegistrationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PcareRegistration[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PcareRegistration|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
