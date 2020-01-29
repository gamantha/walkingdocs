<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cachebyconsid".
 *
 * @property int $id
 * @property string $consId
 * @property string $sarana_list
 * @property string $poli_list
 * @property string $dokter_list
 * @property string $provider_list
 * @property string $statuspulangrawatinap_list
 * @property string $statuspulang_list
 * @property string $spesialis_list
 * @property string $khusus_list
 * @property string $created_at
 * @property string $modified_at
 */
class Cachebyconsid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cachebyconsid';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sarana_list', 'poli_list', 'dokter_list', 'provider_list', 'statuspulangrawatinap_list', 'statuspulang_list', 'spesialis_list', 'khusus_list'], 'string'],
            [['created_at', 'modified_at'], 'safe'],
            [['consId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'consId' => Yii::t('app', 'Cons ID'),
            'sarana_list' => Yii::t('app', 'Sarana List'),
            'poli_list' => Yii::t('app', 'Poli List'),
            'dokter_list' => Yii::t('app', 'Dokter List'),
            'provider_list' => Yii::t('app', 'Provider List'),
            'statuspulangrawatinap_list' => Yii::t('app', 'Statuspulangrawatinap List'),
            'statuspulang_list' => Yii::t('app', 'Statuspulang List'),
            'spesialis_list' => Yii::t('app', 'Spesialis List'),
            'khusus_list' => Yii::t('app', 'Khusus List'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CachebyconsidQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CachebyconsidQuery(get_called_class());
    }
}
