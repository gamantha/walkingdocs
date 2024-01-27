<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Peserta]].
 *
 * @see Peserta
 */
class PesertaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Peserta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Peserta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
