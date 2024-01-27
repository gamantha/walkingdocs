<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[Lb1Data]].
 *
 * @see Lb1Data
 */
class Lb1DataQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Lb1Data[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Lb1Data|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
