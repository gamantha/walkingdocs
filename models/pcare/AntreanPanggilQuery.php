<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[AntreanPanggil]].
 *
 * @see AntreanPanggil
 */
class AntreanPanggilQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AntreanPanggil[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AntreanPanggil|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
