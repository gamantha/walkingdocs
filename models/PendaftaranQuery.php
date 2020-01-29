<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pendaftaran]].
 *
 * @see Pendaftaran
 */
class PendaftaranQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Pendaftaran[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Pendaftaran|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
