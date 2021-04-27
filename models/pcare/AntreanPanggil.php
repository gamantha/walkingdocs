<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "antrean_panggil".
 *
 * @property string|null $tanggalPeriksa
 * @property string|null $clinicId
 * @property string|null $kdPoli
 * @property int|null $nomorpanggilterakhir
 */
class AntreanPanggil extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'antrean_panggil';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggalPeriksa'], 'safe'],
            [['nomorpanggilterakhir'], 'integer'],
            [['clinicId', 'kdPoli'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tanggalPeriksa' => Yii::t('app', 'Tanggal Periksa'),
            'clinicId' => Yii::t('app', 'Clinic ID'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'nomorpanggilterakhir' => Yii::t('app', 'Nomorpanggilterakhir'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AntreanPanggilQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AntreanPanggilQuery(get_called_class());
    }
}
