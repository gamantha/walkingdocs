<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[Tindakan]].
 *
 * @see Tindakan
 */
class TindakanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Tindakan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tindakan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
