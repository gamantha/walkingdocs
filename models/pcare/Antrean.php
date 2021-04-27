<?php

namespace app\models\pcare;

use Yii;

/**
 * This is the model class for table "antrean".
 *
 * @property int $id
 * @property string|null $noKartu
 * @property string|null $nik
 * @property string|null $clinicId
 * @property string|null $tanggalPeriksa
 * @property string|null $kdPoli
 * @property string|null $nmPoli
 * @property string|null $noAntrean
 * @property string|null $angkaAntrean
 * @property string|null $antreanPanggil
 * @property string|null $keterangan
 * @property string|null $status
 */
class Antrean extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'antrean';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tanggalPeriksa'], 'safe'],
            [['noKartu', 'nik', 'clinicId', 'kdPoli', 'nmPoli', 'noAntrean', 'angkaAntrean', 'antreanPanggil', 'keterangan', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'noKartu' => Yii::t('app', 'No Kartu'),
            'nik' => Yii::t('app', 'Nik'),
            'clinicId' => Yii::t('app', 'Clinic ID'),
            'tanggalPeriksa' => Yii::t('app', 'Tanggal Periksa'),
            'kdPoli' => Yii::t('app', 'Kd Poli'),
            'nmPoli' => Yii::t('app', 'Nm Poli'),
            'noAntrean' => Yii::t('app', 'No Antrean'),
            'angkaAntrean' => Yii::t('app', 'Angka Antrean'),
            'antreanPanggil' => Yii::t('app', 'Antrean Panggil'),
            'keterangan' => Yii::t('app', 'Keterangan'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return AntreanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AntreanQuery(get_called_class());
    }
}
