<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "icd10".
 *
 * @property int $id
 * @property string $category_a
 * @property string $category_b
 * @property string $icd10
 * @property string $name
 * @property string $name1
 * @property string $name2
 */
class Icd10 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'icd10';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_a', 'category_b', 'icd10', 'name', 'name1', 'name2'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_a' => Yii::t('app', 'Category A'),
            'category_b' => Yii::t('app', 'Category B'),
            'icd10' => Yii::t('app', 'Icd10'),
            'name' => Yii::t('app', 'Name'),
            'name1' => Yii::t('app', 'Name1'),
            'name2' => Yii::t('app', 'Name2'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return Icd10Query the active query used by this AR class.
     */
    public static function find()
    {
        return new Icd10Query(get_called_class());
    }
}
