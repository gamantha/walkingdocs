<?php

namespace app\models\learning;

/**
 * This is the ActiveQuery class for [[ToolOutput]].
 *
 * @see ToolOutput
 */
class ToolOutputQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ToolOutput[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ToolOutput|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
