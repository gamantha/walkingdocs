<?php

namespace app\models\reporting;

use Yii;

/**
 * This is the model class for table "lb3_values".
 *
 * @property int $id
 * @property int|null $report_id
 * @property int|null $kia_gizi_1
 * @property int|null $kia_gizi_2
 * @property int|null $kia_gizi_3
 * @property int|null $kia_besi_1
 * @property int|null $kia_besi_2
 * @property int|null $kia_besi_3
 * @property int|null $kia_besi_4
 * @property int|null $kia_besi_5
 * @property int|null $kia_besi_6
 * @property int|null $kia_besi_7
 * @property int|null $kia_besi_8
 * @property int|null $kia_besi_9
 * @property int|null $kia_besi_10
 * @property int|null $kia_besi_11
 * @property int|null $kia_besi_12
 * @property int|null $kia_balita_1
 * @property int|null $kia_balita_2
 * @property int|null $kia_balita_3
 * @property int|null $kia_balita_4
 * @property int|null $kia_balita_5
 * @property int|null $kia_balita_6
 * @property int|null $kia_balita_7
 * @property int|null $kia_balita_8
 * @property int|null $kia_balita_9
 * @property int|null $kia_balita_10
 * @property int|null $kia_gaky_1
 * @property int|null $kia_gaky_2
 * @property int|null $kia_gaky_3
 * @property int|null $kia_gaky_4
 * @property int|null $kia_kek_1
 * @property int|null $kia_kek_2
 * @property int|null $kia_kek_3
 * @property int|null $kia_kek_4
 */
class Lb3Values extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb3_values';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('reportingdb');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_id', 'kia_gizi_1', 'kia_gizi_2', 'kia_gizi_3', 'kia_besi_1', 'kia_besi_2', 'kia_besi_3', 'kia_besi_4', 'kia_besi_5', 'kia_besi_6', 'kia_besi_7', 'kia_besi_8', 'kia_besi_9', 'kia_besi_10', 'kia_besi_11', 'kia_besi_12', 'kia_balita_1', 'kia_balita_2', 'kia_balita_3', 'kia_balita_4', 'kia_balita_5', 'kia_balita_6', 'kia_balita_7', 'kia_balita_8', 'kia_balita_9', 'kia_balita_10', 'kia_gaky_1', 'kia_gaky_2', 'kia_gaky_3', 'kia_gaky_4', 'kia_kek_1', 'kia_kek_2', 'kia_kek_3', 'kia_kek_4'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'report_id' => Yii::t('app', 'Report ID'),
            'kia_gizi_1' => Yii::t('app', 'Kia Gizi 1'),
            'kia_gizi_2' => Yii::t('app', 'Kia Gizi 2'),
            'kia_gizi_3' => Yii::t('app', 'Kia Gizi 3'),
            'kia_besi_1' => Yii::t('app', 'Kia Besi 1'),
            'kia_besi_2' => Yii::t('app', 'Kia Besi 2'),
            'kia_besi_3' => Yii::t('app', 'Kia Besi 3'),
            'kia_besi_4' => Yii::t('app', 'Kia Besi 4'),
            'kia_besi_5' => Yii::t('app', 'Kia Besi 5'),
            'kia_besi_6' => Yii::t('app', 'Kia Besi 6'),
            'kia_besi_7' => Yii::t('app', 'Kia Besi 7'),
            'kia_besi_8' => Yii::t('app', 'Kia Besi 8'),
            'kia_besi_9' => Yii::t('app', 'Kia Besi 9'),
            'kia_besi_10' => Yii::t('app', 'Kia Besi 10'),
            'kia_besi_11' => Yii::t('app', 'Kia Besi 11'),
            'kia_besi_12' => Yii::t('app', 'Kia Besi 12'),
            'kia_balita_1' => Yii::t('app', 'Kia Balita 1'),
            'kia_balita_2' => Yii::t('app', 'Kia Balita 2'),
            'kia_balita_3' => Yii::t('app', 'Kia Balita 3'),
            'kia_balita_4' => Yii::t('app', 'Kia Balita 4'),
            'kia_balita_5' => Yii::t('app', 'Kia Balita 5'),
            'kia_balita_6' => Yii::t('app', 'Kia Balita 6'),
            'kia_balita_7' => Yii::t('app', 'Kia Balita 7'),
            'kia_balita_8' => Yii::t('app', 'Kia Balita 8'),
            'kia_balita_9' => Yii::t('app', 'Kia Balita 9'),
            'kia_balita_10' => Yii::t('app', 'Kia Balita 10'),
            'kia_gaky_1' => Yii::t('app', 'Kia Gaky 1'),
            'kia_gaky_2' => Yii::t('app', 'Kia Gaky 2'),
            'kia_gaky_3' => Yii::t('app', 'Kia Gaky 3'),
            'kia_gaky_4' => Yii::t('app', 'Kia Gaky 4'),
            'kia_kek_1' => Yii::t('app', 'Kia Kek 1'),
            'kia_kek_2' => Yii::t('app', 'Kia Kek 2'),
            'kia_kek_3' => Yii::t('app', 'Kia Kek 3'),
            'kia_kek_4' => Yii::t('app', 'Kia Kek 4'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return Lb3ValuesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new Lb3ValuesQuery(get_called_class());
    }
}
