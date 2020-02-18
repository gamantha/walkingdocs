<?php

namespace app\models\reporting;

/**
 * This is the ActiveQuery class for [[ReportTemplate]].
 *
 * @see ReportTemplate
 */
class ReportTemplateQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ReportTemplate[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ReportTemplate|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
