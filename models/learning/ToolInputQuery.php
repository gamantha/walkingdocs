<?php

namespace app\models\learning;

/**
 * This is the ActiveQuery class for [[ToolInput]].
 *
 * @see ToolInput
 */
class ToolInputQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ToolInput[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ToolInput|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
