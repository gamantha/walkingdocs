<?php

namespace app\models\pcare;

/**
 * This is the ActiveQuery class for [[PcareKegiatan]].
 *
 * @see PcareKegiatan
 */
class PcareKegiatanQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PcareKegiatan[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PcareKegiatan|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
