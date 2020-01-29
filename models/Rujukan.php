<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rujukan".
 *
 * @property int $id
 * @property int $kunjungan_id
 * @property string $tipe_rujukan
 * @property string $tanggal_estimasi
 * @property string $kdppk
 * @property string $subspesialisJson
 * @property string $kdSpesialis
 * @property string $kdSubSpesialis1
 * @property string $kdSarana
 * @property string $khususJson
 * @property string $kdKhusus
 * @property string $kdSubSpesialisKhusus
 * @property string $kdPpkKhusus
 * @property string $catatan
 *
 * @property Kunjungan $kunjungan
 */
class Rujukan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rujukan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                ['tanggal_estimasi'],'validateTanggalEstimasi'
            ],
            [['kunjungan_id'], 'integer'],
            //[['kdppk','kdSpesialis','kdSubSpesialis1'], 'required'],
            [['kdppk','kdSpesialis','kdSubSpesialis1','kdSarana', 'kdKhusus', 'kdSubSpesialisKhusus','kdPpkKhusus'], 'default', 'value' => null],
            [['tanggal_estimasi'], 'safe'],
            [['subspesialisJson', 'khususJson', 'catatan'], 'string'],
            [['tipe_rujukan', 'kdppk', 'kdSpesialis', 'kdSubSpesialis1', 'kdSarana', 'kdKhusus', 'kdSubSpesialisKhusus', 'kdPpkKhusus'], 'string', 'max' => 255],
            [['kunjungan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kunjungan::className(), 'targetAttribute' => ['kunjungan_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'kunjungan_id' => Yii::t('app', 'Kunjungan ID'),
            'tipe_rujukan' => Yii::t('app', 'Tipe Rujukan'),
            'tanggal_estimasi' => Yii::t('app', 'Tanggal Estimasi'),
            'kdppk' => Yii::t('app', 'Kdppk'),
            'subspesialisJson' => Yii::t('app', 'Subspesialis Json'),
            'kdSpesialis' => Yii::t('app', 'Kd Spesialis'),
            'kdSubSpesialis1' => Yii::t('app', 'Kd Sub Spesialis1'),
            'kdSarana' => Yii::t('app', 'Kd Sarana'),
            'khususJson' => Yii::t('app', 'Khusus Json'),
            'kdKhusus' => Yii::t('app', 'Kd Khusus'),
            'kdSubSpesialisKhusus' => Yii::t('app', 'Kd Sub Spesialis Khusus'),
            'kdPpkKhusus' => Yii::t('app', 'Kd Ppk Khusus'),
            'catatan' => Yii::t('app', 'Catatan'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKunjungan()
    {
        return $this->hasOne(Kunjungan::className(), ['id' => 'kunjungan_id']);
    }

    /**
     * {@inheritdoc}
     * @return RujukanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RujukanQuery(get_called_class());
    }


    public function validateTanggalEstimasi($attribute, $params) {
        $date = new \DateTime();
        date_sub($date, date_interval_create_from_date_string('0     day'));
        $minDate = date_format($date, 'Y-m-d');

        if ($this->$attribute < $minDate) {
            $this->addError($attribute, 'Tidak boleh kurang dari tanggal ini.');
            return false;
        }
    }


}
