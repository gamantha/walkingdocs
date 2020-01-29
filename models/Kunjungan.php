<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kunjungan".
 *
 * @property int $id
 * @property int $pendaftaran_id
 * @property string $jenis_kunjungan
 * @property string $tanggal_kunjungan
 * @property string $poli_tujuan
 * @property string $perawatan
 * @property string $kode_sadar
 * @property string $keluhan
 * @property int $sistole
 * @property int $diastole
 * @property int $tinggi_badan
 * @property int $berat_badan
 * @property int $respiratory_rate
 * @property int $heart_rate
 * @property int $lingkar_perut
 * @property int $imt
 * @property string $bpjs_kunjungan_response
 * @property string $bpjs_kunjungan_status
 * @property string $bpjs_kunjungan_no
 * @property string $kode_dokter
 * @property string $kode_diagnosa1
 * @property string $kode_diagnosa2
 * @property string $kode_diagnosa3
 * @property string $terapi
 * @property string $kode_status_pulang
 * @property string $tanggal_pulang
 * @property string $kode_poli_rujuk_internal
 * @property string $rujuk_lanjut_tanggal_rujuk
 * @property string $rujuk_lanjut_kode_ppk
 * @property string $rujuk_lanjut_subspesialis
 * @property string $rujuk_lanjut_khusus
 * @property int $rujukBalik
 * @property string $kdTkp
 * @property bool $kunjSakit
 * @property string $status
 * @property string $created_at
 * @property string $modified_at
 *
 * @property Pendaftaran $pendaftaran
 * @property Rujukan[] $rujukans
 */
class Kunjungan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kunjungan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pendaftaran_id', 'sistole', 'diastole', 'tinggi_badan', 'berat_badan', 'respiratory_rate', 'heart_rate', 'lingkar_perut', 'imt', 'rujukBalik'], 'integer'],
            [['tanggal_kunjungan', 'tanggal_pulang', 'rujuk_lanjut_tanggal_rujuk', 'created_at', 'modified_at'], 'safe'],
            [['keluhan', 'bpjs_kunjungan_response', 'terapi', 'rujuk_lanjut_subspesialis', 'rujuk_lanjut_khusus'], 'string'],
            [['kunjSakit'], 'boolean'],
            [['jenis_kunjungan', 'poli_tujuan', 'perawatan', 'kode_sadar', 'bpjs_kunjungan_status', 'bpjs_kunjungan_no', 'kode_dokter', 'kode_diagnosa1', 'kode_diagnosa2', 'kode_diagnosa3', 'kode_status_pulang', 'kode_poli_rujuk_internal', 'rujuk_lanjut_kode_ppk', 'kdTkp', 'status'], 'string', 'max' => 255],
            [['pendaftaran_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pendaftaran::className(), 'targetAttribute' => ['pendaftaran_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'pendaftaran_id' => Yii::t('app', 'Pendaftaran ID'),
            'jenis_kunjungan' => Yii::t('app', 'Jenis Kunjungan'),
            'tanggal_kunjungan' => Yii::t('app', 'Tanggal Kunjungan'),
            'poli_tujuan' => Yii::t('app', 'Poli Tujuan'),
            'perawatan' => Yii::t('app', 'Perawatan'),
            'kode_sadar' => Yii::t('app', 'Kode Sadar'),
            'keluhan' => Yii::t('app', 'Keluhan'),
            'sistole' => Yii::t('app', 'Sistole'),
            'diastole' => Yii::t('app', 'Diastole'),
            'tinggi_badan' => Yii::t('app', 'Tinggi Badan'),
            'berat_badan' => Yii::t('app', 'Berat Badan'),
            'respiratory_rate' => Yii::t('app', 'Respiratory Rate'),
            'heart_rate' => Yii::t('app', 'Heart Rate'),
            'lingkar_perut' => Yii::t('app', 'Lingkar Perut'),
            'imt' => Yii::t('app', 'Imt'),
            'bpjs_kunjungan_response' => Yii::t('app', 'Bpjs Kunjungan Response'),
            'bpjs_kunjungan_status' => Yii::t('app', 'Bpjs Kunjungan Status'),
            'bpjs_kunjungan_no' => Yii::t('app', 'Bpjs Kunjungan No'),
            'kode_dokter' => Yii::t('app', 'Kode Dokter'),
            'kode_diagnosa1' => Yii::t('app', 'Kode Diagnosa1'),
            'kode_diagnosa2' => Yii::t('app', 'Kode Diagnosa2'),
            'kode_diagnosa3' => Yii::t('app', 'Kode Diagnosa3'),
            'terapi' => Yii::t('app', 'Terapi'),
            'kode_status_pulang' => Yii::t('app', 'Kode Status Pulang'),
            'tanggal_pulang' => Yii::t('app', 'Tanggal Pulang'),
            'kode_poli_rujuk_internal' => Yii::t('app', 'Kode Poli Rujuk Internal'),
            'rujuk_lanjut_tanggal_rujuk' => Yii::t('app', 'Rujuk Lanjut Tanggal Rujuk'),
            'rujuk_lanjut_kode_ppk' => Yii::t('app', 'Rujuk Lanjut Kode Ppk'),
            'rujuk_lanjut_subspesialis' => Yii::t('app', 'Rujuk Lanjut Subspesialis'),
            'rujuk_lanjut_khusus' => Yii::t('app', 'Rujuk Lanjut Khusus'),
            'rujukBalik' => Yii::t('app', 'Rujuk Balik'),
            'kdTkp' => Yii::t('app', 'Kd Tkp'),
            'kunjSakit' => Yii::t('app', 'Kunj Sakit'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'modified_at' => Yii::t('app', 'Modified At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPendaftaran()
    {
        return $this->hasOne(Pendaftaran::className(), ['id' => 'pendaftaran_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRujukans()
    {
        return $this->hasMany(Rujukan::className(), ['kunjungan_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return KunjunganQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KunjunganQuery(get_called_class());
    }
}
