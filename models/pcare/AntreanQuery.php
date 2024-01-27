<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[Antrean]].
 *
 * @see Antrean
 */
class AntreanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Antrean[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Antrean|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
